import cv2
import numpy as np
import pytesseract
import os, sys
from PIL import Image

# Path of working folder on Disk
#src_path = "E:/Lab/Python/Project/OCR/"
#pytesseract.pytesseract.tesseract_cmd = 'C:\\Program Files (x86)\\Tesseract-OCR\\tesseract.exe'


def get_string(file):
    # Read image with opencv

    img = cv2.imread(file)


    # Convert to gray
    img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)

    # Apply dilation and erosion to remove some noise
    kernel = np.ones((1, 1), np.uint8)
    img = cv2.dilate(img, kernel, iterations=1)
    img = cv2.erode(img, kernel, iterations=1)

    # Write image after removed noise
    #cv2.imwrite("removed_noise.png", img)

    #  Apply threshold to get image with only black and white
    img = cv2.adaptiveThreshold(img, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY, 31, 2)

    # Write the image after apply opencv to do some ...

    #img = cv2.imread('removed_noise.png', cv2.IMREAD_GRAYSCALE)
    #img = cv2.resize(img, (1000, 100))  # upscale
    #img = cv2.filter2D(img, -1, np.array([-1, 4, -1]))  # sharpen
    #cv2.imwrite("thres.png", img)

    # Recognize text with tesseract for python
    result = pytesseract.image_to_string(img, lang="Consolas", config='--psm 6 --oem 0')

    # Remove template file
    #os.remove(temp)

    return result


if len(sys.argv) != 2:
    print("This takes 1 argument : \n1) The combined image path")
    exit()
filename = str(sys.argv[1])

get_letters = get_string(filename)

combined = ''.join(map(str, get_letters))

print(combined)