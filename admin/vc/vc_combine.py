#!C:\Python37\python.exe
import os, sys
from PIL import Image

if len(sys.argv)!=5:
	print("This takes 4 argument : \n1) The 2 share image names \n2) aId \n3) Path.")
	exit()
infile=str(sys.argv[1])

shareFile1_str=str(sys.argv[1])
shareFile2_str=str(sys.argv[2])
aId=str(sys.argv[3])
path=str(sys.argv[4])
infile1 = Image.open(shareFile1_str)
infile2 = Image.open(shareFile2_str)


output_filename= os.path.dirname(os.path.abspath(__file__)) + '/tmp/'+ aId+"_JOINED.png"
#output_location = os.path.join('tmp',aId+"_JOINED.png")


outfile = Image.new('1', infile1.size,'white')

for x in range(infile1.size[0]):
    for y in range(infile1.size[1]):
        outfile.putpixel((x, y), min(infile1.getpixel((x, y)), infile2.getpixel((x, y))))

width = outfile.size[0]
height = outfile.size[1]
x = 0
y = 0

while x < width:
    while y < height:
        pixel1 = outfile.getpixel((x, y))
        pixel2 = outfile.getpixel((x + 1, y))
        pixel3 = outfile.getpixel((x, y + 1))
        pixel4 = outfile.getpixel((x + 1, y + 1))

        if pixel1 == 255 or pixel2 == 255 or pixel3 == 255 or pixel4 == 255:
            outfile.putpixel((x, y), 255)
            outfile.putpixel((x + 1, y), 255)
            outfile.putpixel((x, y + 1), 255)
            outfile.putpixel((x + 1, y + 1), 255)

        y += 2
    y = 0
    x += 2

outfile.save(output_filename, 'PNG')
print("** [SCRIPT]Join Success. **")
print(infile1.getpixel((10, 10)))
print(infile2.getpixel((15, 20)))
