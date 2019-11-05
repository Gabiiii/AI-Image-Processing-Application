#import argparse
import time

import torch
from PIL import Image
from torch.autograd import Variable
from torchvision.transforms import ToTensor, ToPILImage

from model import Generator

try:
    torch._utils._rebuild_tensor_v2
except AttributeError:
    def _rebuild_tensor_v2(storage, storage_offset, size, stride, requires_grad, backward_hooks):
        tensor = torch._utils._rebuild_tensor(storage, storage_offset, size, stride)
        tensor.requires_grad = requires_grad
        tensor._backward_hooks = backward_hooks
        return tensor
    torch._utils._rebuild_tensor_v2 = _rebuild_tensor_v2

"""
parser = argparse.ArgumentParser(description='Test Single Image')
parser.add_argument('--upscale_factor', default=4, type=int, help='super resolution upscale factor')
parser.add_argument('--test_mode', default='GPU', type=str, choices=['GPU', 'CPU'], help='using GPU or CPU')
parser.add_argument('--image_name', type=str, help='test low resolution image name')
parser.add_argument('--model_name', default='netG_epoch_4_100.pth', type=str, help='generator model epoch name')

opt = parser.parse_args()
UPSCALE_FACTOR = opt.upscale_factor
TEST_MODE = True if opt.test_mode == 'GPU' else False
IMAGE_NAME = opt.image_name
MODEL_NAME = opt.model_name
여기 gradu_pjt
"""

UPSCALE_FACTOR = 4
IMAGE_NAME = 'test_1.jpg'
MODEL_NAME = 'netG_epoch_4_100.pth'

model = Generator(UPSCALE_FACTOR).eval()
model.cuda()
model.load_state_dict(torch.load(MODEL_NAME, map_location=lambda storage, _:storage))
#model.load_state_dict(torch.load('epochs/' + MODEL_NAME))

image = Image.open(IMAGE_NAME)
image = Variable(ToTensor()(image), volatile=True).unsqueeze(0)
image = image.cuda()
start = time.clock()
out = model(image)

elapsed = (time.clock() - start)
print('cost' + str(elapsed) + 's')
out_img = ToPILImage()(out[0].data.cpu())
out_img.save('out_srf_' + str(UPSCALE_FACTOR) + '_' + IMAGE_NAME)
"""

UPSCALE_FACTOR = 4
TEST_MODE = 'GPU'
IMAGE_NAME = '0827x4.jpg'
MODEL_NAME = 'netG_epoch_4_100.pth'


model = Generator(UPSCALE_FACTOR).eval()
if TEST_MODE:
    model.cuda()
    model.load_state_dict(torch.load('epochs/' + MODEL_NAME))
else:
    model.load_state_dict(torch.load('epochs/' + MODEL_NAME, map_location=lambda storage, loc: storage))

image = Image.open(IMAGE_NAME)
image = Variable(ToTensor()(image), volatile=True).unsqueeze(0)
if TEST_MODE:
    image = image.cuda()

start = time.clock()
out = model(image)
elapsed = (time.clock() - start)
print('cost' + str(elapsed) + 's')
out_img = ToPILImage()(out[0].data.cpu())
out_img.save('out_srf_' + str(UPSCALE_FACTOR) + '_' + IMAGE_NAME)
"""