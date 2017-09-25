from PIL import Image, ImageDraw, ImageFont, ImageColor, ImagePalette
import os

def Kelvin2Celsius(t):
    kelvin = -273.15
    return t + kelvin

def Celsius2Kelvin(t):
    kelvin = -273.15
    return t - kelvin

def temptoindex(t, temp_max, temp_min):
    return int((temp_max - t)*256/(temp_max - temp_min + .0001))

def creapaleta(i_tempcol):
    lut = []
    for i in range(256):
        if (i > i_tempcol):
            sc = str(int((i - i_tempcol)*360/(256 - i_tempcol)))
            color = ImageColor.getrgb("hsl("+sc+",100%,50%)")
        else:
            c = int(255.0*i/i_tempcol)
            color = [c,c,c]
        lut.extend(color)
    return lut

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

def haztitulo(im, t, i_tempcol):
    x1 = 1250
    y1 = 0
    x2 =1840
    y2 = 40
    fsize = 32
    draw = ImageDraw.Draw(im)
    draw.rectangle(((x1, y1), (x2, y2)), fill=1)
    draw.text((x1+fsize/2, y1+4), t, fill=i_tempcol, font=ImageFont.truetype(os.path.dirname(os.path.realpath(__file__))+"/FreeMonoBold.ttf", fsize))
