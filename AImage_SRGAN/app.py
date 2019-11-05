from flask import Flask, jsonify, request
import time

import torch
from PIL import Image
from torch.autograd import Variable
from torchvision.transforms import ToTensor, ToPILImage
from model import Generator
import boto3

try:
    torch._utils._rebuild_tensor_v2
except AttributeError:
    def _rebuild_tensor_v2(storage, storage_offset, size, stride, requires_grad, backward_hooks):
        tensor = torch._utils._rebuild_tensor(storage, storage_offset, size, stride)
        tensor.requires_grad = requires_grad
        tensor._backward_hooks = backward_hooks
        return tensor
    torch._utils._rebuild_tensor_v2 = _rebuild_tensor_v2

def test_image(fileName):
    UPSCALE_FACTOR = 4
    IMAGE_NAME = fileName
    MODEL_NAME = 'netG_epoch_4_100.pth'
    
    model = Generator(UPSCALE_FACTOR).eval()
    model.cuda()
    model.load_state_dict(torch.load(MODEL_NAME, map_location=lambda storage, _:storage))
    #model.load_state_dict(torch.load('epochs/' + MODEL_NAME))
    
    image = Image.open("./download_tmp/"+IMAGE_NAME)
    image = Variable(ToTensor()(image), volatile=True).unsqueeze(0)
    image = image.cuda()
    start = time.clock()
    out = model(image)
    
    elapsed = (time.clock() - start)
    print('cost' + str(elapsed) + 's')
    out_img = ToPILImage()(out[0].data.cpu())
    out_img.save('./result/out_srf_' + str(UPSCALE_FACTOR) + '_' + IMAGE_NAME)
    return './result/out_srf_' + str(UPSCALE_FACTOR) + '_' + IMAGE_NAME

app = Flask(__name__)

s3 = boto3.client('s3')
input_bucket="elasticbeanstalk-us-east-1-045951459452"
result_bucket="output-after"

@app.route('/srgan', methods=['POST'])
def srgan():
    # doc = {"file_name":"name"}
    reqJson = request.get_json()
    doc = {"file_name":reqJson["file_name"]}
    print(doc)
    s3.download_file(input_bucket,doc["file_name"],"./download_tmp/"+reqJson["file_name"])
    out_name = test_image(reqJson["file_name"])
    #    return jsonify({"message":"failure"}),502
    s3.upload_file(out_name,result_bucket,"out_srf_4_"+doc["file_name"])
    return jsonify(doc), 200


if __name__ == '__main__':
    app.run('0.0.0.0',port=5000)