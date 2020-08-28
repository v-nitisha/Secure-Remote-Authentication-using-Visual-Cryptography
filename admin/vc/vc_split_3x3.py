#!C:\Python37\python.exe
# USAGE: python visual_cryptography.py file_to_encrypt.png
import PIL
from PIL import Image, ImageDraw
import os, sys
from random import SystemRandom

random = SystemRandom()
# If you want to use the more powerful PyCrypto (pip install pycrypto) then uncomment the next line and comment out the previous two lines
# from Crypto.Random import random

if len(sys.argv) != 4:
    print("This takes 2 argument : \n1)Image to split \n2)Admin ID \n3)Path")
    exit()
infile = str(sys.argv[1])
aId = str(sys.argv[2])
path = str(sys.argv[3])

if not os.path.isfile(infile):
    print("That file does not exist.")
    exit()

img = Image.open(infile)

f, e = os.path.splitext(infile)

out_filename_A = f + "_A.png"
out_filename_B = f + "_B.png"
out_filename_C = f + "_C.png"

img = img.convert('1')  # convert image to 1 bit

# Prepare two empty slider images for drawing
width = img.size[0] * 2
height = img.size[1] * 2
out_image_A = Image.new('1', (width, height))
out_image_B = Image.new('1', (width, height))
out_image_C = Image.new('1', (width, height))

draw_A = ImageDraw.Draw(out_image_A)
draw_B = ImageDraw.Draw(out_image_B)
draw_C = ImageDraw.Draw(out_image_C)

patterns_w = (
(0, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0, 1), (0, 0, 1, 1, 0, 1, 1, 0, 1, 0, 1, 0), (0, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 1),
(0, 1, 1, 0, 0, 0, 1, 1, 1, 0, 1, 0), (0, 1, 0, 1, 0, 1, 1, 0, 1, 1, 0, 0), (0, 1, 1, 0, 0, 1, 0, 1, 1, 1, 0, 0),
(0, 0, 1, 1, 1, 0, 0, 1, 0, 1, 0, 1), (0, 0, 1, 1, 1, 0, 1, 0, 0, 1, 1, 0), (0, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1, 1),
(0, 1, 1, 0, 1, 0, 1, 0, 0, 0, 1, 1), (0, 1, 0, 1, 1, 1, 0, 0, 0, 1, 1, 0), (0, 1, 1, 0, 1, 1, 0, 0, 0, 1, 0, 1),
(1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 1), (1, 0, 1, 0, 0, 0, 1, 1, 0, 1, 1, 0), (1, 0, 0, 1, 0, 1, 0, 1, 0, 0, 1, 1),
(1, 0, 1, 0, 0, 1, 1, 0, 0, 0, 1, 1), (1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 1, 0), (1, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, 1),
(1, 0, 0, 1, 1, 0, 1, 0, 1, 1, 0, 0), (1, 0, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0), (1, 0, 0, 1, 1, 1, 0, 0, 1, 0, 1, 0),
(1, 0, 1, 0, 1, 1, 0, 0, 1, 0, 0, 1), (1, 1, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0), (1, 1, 0, 0, 1, 0, 1, 0, 1, 0, 0, 1))
patterns_b = (
(0, 0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0), (0, 0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1), (0, 1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0),
(0, 1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 1), (0, 1, 0, 1, 0, 1, 1, 0, 0, 0, 1, 1), (0, 1, 1, 0, 0, 1, 0, 1, 0, 0, 1, 1),
(0, 0, 1, 1, 1, 0, 0, 1, 1, 0, 1, 0), (0, 0, 1, 1, 1, 0, 1, 0, 1, 0, 0, 1), (0, 1, 0, 1, 1, 0, 0, 1, 1, 1, 0, 0),
(0, 1, 1, 0, 1, 0, 1, 0, 1, 1, 0, 0), (0, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 1), (0, 1, 1, 0, 1, 1, 0, 0, 1, 0, 1, 0),
(1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 1, 0), (1, 0, 1, 0, 0, 0, 1, 1, 1, 0, 0, 1), (1, 0, 0, 1, 0, 1, 0, 1, 1, 1, 0, 0),
(1, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0, 0), (1, 1, 0, 0, 0, 1, 0, 1, 1, 0, 0, 1), (1, 1, 0, 0, 0, 1, 1, 0, 1, 0, 1, 0),
(1, 0, 0, 1, 1, 0, 1, 0, 0, 0, 1, 1), (1, 0, 1, 0, 1, 0, 0, 1, 0, 0, 1, 1), (1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 0, 1),
(1, 0, 1, 0, 1, 1, 0, 0, 0, 1, 1, 0), (1, 1, 0, 0, 1, 0, 0, 1, 0, 1, 0, 1), (1, 1, 0, 0, 1, 0, 1, 0, 0, 1, 1, 0))
# Cycle through pixels
for x in range(0, width // 2):
    for y in range(0, height // 2):
        pixel = img.getpixel((x, y))
        if pixel == 0:
            pat = random.choice(patterns_b)
        else:
            pat = random.choice(patterns_w)

        draw_A.point((x * 2, y * 2), pat[0])
        draw_A.point((x * 2 + 1, y * 2), pat[1])
        draw_A.point((x * 2, y * 2 + 1), pat[2])
        draw_A.point((x * 2 + 1, y * 2 + 1), pat[3])

        draw_B.point((x * 2, y * 2), pat[4])
        draw_B.point((x * 2 + 1, y * 2), pat[5])
        draw_B.point((x * 2, y * 2 + 1), pat[6])
        draw_B.point((x * 2 + 1, y * 2 + 1), pat[7])

        draw_C.point((x * 2, y * 2), pat[8])
        draw_C.point((x * 2 + 1, y * 2), pat[9])
        draw_C.point((x * 2, y * 2 + 1), pat[10])
        draw_C.point((x * 2 + 1, y * 2 + 1), pat[11])

out_image_A.save(out_filename_A, 'PNG')
out_image_B.save(out_filename_B, 'PNG')
out_image_C.save(out_filename_C, 'PNG')

print("** [SCRIPT]Splitting Image Done. **")
