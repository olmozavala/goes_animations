#! /usr/bin/python
# -*- coding: utf-8 -*-
# imagefromgoes.py

# Copyright (c) 2017, Alejandro Aguilar Sierra
# Copyright (c) 2017, Centro de Ciencias de la Atmosfera, UNAM
# All rights reserved.
# Version: 2017.08.30.01
#
# Requirements:  these libraries, the font FreeMonoBold.ttf and
# the PNG file marco.png

import sys
import os
import tifffile as tiff
import numpy as np
from PIL import Image, ImageDraw, ImageFont, ImageColor, ImagePalette
from PIL.ImageColor import *
import datetime

kelvin = -273.15
temp_min = 0
temp_max = 0
i_tempcol = 0

def Kelvin2Celsius(t):
    global kelvin
    return t + kelvin

def Celsius2Kelvin(t):
    global kelvin
    return t - kelvin

def temptoindex(t):
    global temp_min, temp_max
    return int((temp_max - t)*256/(temp_max - temp_min))

def creapaleta(i_tempcol):
    lut = []
    for i in range(256):
        if (i > i_tempcol):
            sc = str(int((i - i_tempcol)*360/(256 - i_tempcol)))
            color = getrgb("hsl("+sc+",100%,50%)")
        else:
            c = int(255.0*i/i_tempcol)
            color = [c,c,c]
        lut.extend(color)
    return lut

def hazbarra(im):
    global i_tempcol
    xc = 1664
    yc = 1240
    draw = ImageDraw.Draw(im)
    d = 256/(255 - i_tempcol) + 1
    draw.rectangle(((xc, yc), (xc+250, yc+40)), fill=i_tempcol+1)
    x = xc
    for i in range(i_tempcol, 255, 1):
        draw.rectangle(((x, yc), (x+d, yc+40)), fill=i+1)
        x += d

def haztitulo(im, t):
    x1 = 1250
    y1 = 0
    x2 =1840
    y2 = 40
    fsize = 32
    draw = ImageDraw.Draw(im)
    draw.rectangle(((x1, y1), (x2, y2)), fill=0)
    draw.text((x1+fsize/2, y1+4), t, fill=i_tempcol, font=ImageFont.truetype("FreeMonoBold.ttf", fsize))


lenargv = len(sys.argv)
if (lenargv > 1):
    filename = sys.argv[1]
else:
    filename = 'an_image.tif'
if (lenargv > 2):
    resize = int(sys.argv[2])*0.01
else:
    resize = 1.0

name = os.path.splitext(filename)[0]

dt = ""
with tiff.TiffFile(filename) as tif:
    a = tif.asarray()
    for page in tif:
        dt = page.tags['datetime'].value
        print('Date ', dt)
        
h, w = a.shape
temp_min = np.min(a)
temp_max = np.max(a)

print('Temperatures ', temp_min + kelvin, temp_max + kelvin)

imc = Image.new("P", (w, h))
pco = imc.load()
i_tempcol = temptoindex(Celsius2Kelvin(-32.0))
p = creapaleta(i_tempcol)
imc.putpalette(p)

for j in range(h-1):
    for i in range(w-1):
        c = temptoindex(a[j, i])
        pco[i, j] = int(c)
hazbarra(imc)
haztitulo(imc, "GOES16 C13 "+dt)
marco = Image.open("marco.png")
out = imc.convert("RGB")
out.paste(marco, (0,0), marco.convert("L"))
if (resize < 1.0):
    out = out.resize((int(w*resize), int(h*resize)))
out.save(name + '.jpg')
