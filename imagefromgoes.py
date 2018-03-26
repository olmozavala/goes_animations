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
    try:
        kelvin = -273.15
        name = ntpath.basename(filename) 
        dt = ""
        print("BEFORE")
        with tiff.TiffFile(filename) as tif:
            
            imgDataAsNumpy = tif.asarray()
            # Obtains the DateTime from the tiff file and stores it in dt
            print(type(tif))
            for page in tif:
                print("AFTER")
                dt = page.tags['datetime'].value
                dt = dt.decode("utf-8")
                #print('Date ', dt)
                
        # Gets the maximum and minimum values from the image array which is wrong.
        h, w = imgDataAsNumpy.shape

        # Hard code the minimum and maximum values for the color palette
        temp_min = 213.15 # -60 Celsius
        temp_max = np.max(imgDataAsNumpy)

        print('Temperatures ', temp_min + kelvin, temp_max + kelvin)

        imc = Image.new("P", (w, h))
        pco = imc.load()

        # Computes the minimum index for the palette (equivalent to -32 Celsius)
        minTempIdx = int(temptoindex(Celsius2Kelvin(-30.0), temp_max, temp_min))
        p = creapaleta(minTempIdx)
        imc.putpalette(p)

        # Compute the 'color' index temperature value for the image
        temp = ((temp_max - imgDataAsNumpy)*256)/(temp_max - temp_min + .0001)

        for j in range(h-1):
            for i in range(w-1):
                pco[i, j] = int(temp[j,i])

        hazbarra(imc, minTempIdx)
        haztitulo(imc, "GOES16 C13 UTC: "+dt, minTempIdx)

    #    print(os.path.dirname(os.path.realpath(__file__)))
        marco = Image.open(os.path.dirname(os.path.realpath(__file__))+"/marco.png")
        out = imc.convert("RGB")
        out.paste(marco, (0,0), marco.convert("L"))

        if (resize < 1.0):
            out = out.resize((int(w*resize), int(h*resize)))

        out.save(outputFolder+'/'+name + '.jpg')
    except Exception as e:
        print("ERROR: Received at makeJpg")
        print(e)
        raise
