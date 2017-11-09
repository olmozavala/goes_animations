from PIL import Image, ImageDraw, ImageFont, ImageColor, ImagePalette
import os
import matplotlib.pyplot as plt
import numpy as np
from matplotlib.colors import to_hex
import matplotlib.colors as mcolors
import matplotlib.cm as cmx
import matplotlib


def Kelvin2Celsius(t):
    kelvin = -273.15
    return t + kelvin

def Celsius2Kelvin(t):
    kelvin = -273.15
    return t - kelvin

# Transforms the temperature to an index from 0 to 256 (for the color palette)
def temptoindex(t, temp_max, temp_min):
    return (temp_max - t)*256/(temp_max - temp_min + .0001)

# Computes the color palette taking into account the starting index
# where we paint the image
def creapaleta(i_tempcol):
    lut = []

    # Options plasma, virids, jet, inferno, magma
    palette = 'jet'
    ncmap = plt.get_cmap(palette)

    # Verify the two types of colorbars in matplotlib (they don't have the same methos)
    if isinstance(ncmap,matplotlib.colors.LinearSegmentedColormap):
        cNorm  = mcolors.Normalize(vmin=0, vmax=(256 - i_tempcol))
    else:
        colors = ncmap.colors

    # Using
    for i in range(256):
        # If the index is above the minimum color, then we change the color to the one in the color bar
        if (i > i_tempcol):
            if isinstance(ncmap,matplotlib.colors.LinearSegmentedColormap):
                scalarMap = cmx.ScalarMappable(norm=cNorm, cmap=ncmap)
                ncolor = scalarMap.to_rgba(i - i_tempcol)
                color = ImageColor.getrgb(to_hex(ncolor))
            else:
                ncolor = colors[int(np.ceil(i - i_tempcol)*255/(256 - i_tempcol))]
                color = ImageColor.getrgb(to_hex(ncolor))
        else:
        # If the index is below we simply leave the gray index
            c = int(255.0*i/i_tempcol)
            color = [c,c,c]
        lut.extend(color)
    return lut

#
def hazbarra(im,i_tempcol):
    try:
        xc = 1664
        yc = 1240
        draw = ImageDraw.Draw(im)
        d = 256/(255 - i_tempcol) + 1
        draw.rectangle(((xc, yc), (xc+250, yc+40)), fill=i_tempcol+1)
        x = xc
        for i in range(i_tempcol, 255, 1):
            draw.rectangle(((x, yc), (x+d, yc+40)), fill=i+1)
            x += d

    except Exception as e:
        print("ERROR: Problem generating bar")
        print(e)

# Creates the title up on the right
def haztitulo(im, t, i_tempcol):
    x1 = 1200 # Width start (left side)
    y1 = 0  # top start (up)
    x2 =1940 # Width start (right side)
    y2 = 40 # top start (up + some)
    fsize = 32
    draw = ImageDraw.Draw(im)
    draw.rectangle(((x1, y1), (x2, y2)), fill=1)
    draw.text((x1+fsize/2, y1+4), t, fill=i_tempcol, font=ImageFont.truetype(os.path.dirname(os.path.realpath(__file__))+"/FreeMonoBold.ttf", fsize))
