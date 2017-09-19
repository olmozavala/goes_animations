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

import sys, os, ntpath
import tifffile as tiff
import numpy as np
from PIL import Image, ImageDraw, ImageFont, ImageColor, ImagePalette
from PIL.ImageColor import *
from tools import *


#    lenargv = len(sys.argv)
#    if (lenargv > 1):
#        filename = sys.argv[1]
#    else:
#        filename = 'an_image.tif'
#    if (lenargv > 2):
#        resize = int(sys.argv[2])*0.01
#    else:
#        resize = 1.0

def makeJpg(filename, resize, outputFolder):
    kelvin = -273.15
    name = ntpath.basename(filename) 
    dt = ""
    with tiff.TiffFile(filename) as tif:
        a = tif.asarray()
        for page in tif:
            dt = page.tags['datetime'].value
            #print('Date ', dt)
            
    h, w = a.shape
    temp_min = np.min(a)
    temp_max = np.max(a)

    print('Temperatures ', temp_min + kelvin, temp_max + kelvin)

    imc = Image.new("P", (w, h))
    pco = imc.load()
    i_tempcol = temptoindex(Celsius2Kelvin(-32.0), temp_max, temp_min)
    p = creapaleta(i_tempcol)
    imc.putpalette(p)

    for j in range(h-1):
        for i in range(w-1):
            c = temptoindex(a[j, i], temp_max, temp_min)
            pco[i, j] = int(c)
    hazbarra(imc, i_tempcol)
    haztitulo(imc, "GOES16 C13 "+dt, i_tempcol)

#    print(os.path.dirname(os.path.realpath(__file__)))
    marco = Image.open(os.path.dirname(os.path.realpath(__file__))+"/marco.png")
    out = imc.convert("RGB")
    out.paste(marco, (0,0), marco.convert("L"))

    if (resize < 1.0):
        out = out.resize((int(w*resize), int(h*resize)))

    out.save(outputFolder+'/'+name + '.jpg')
