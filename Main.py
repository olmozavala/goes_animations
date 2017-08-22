from ftplib import FTP
from pandas import DataFrame
from datetime import *
import matplotlib.pyplot as plt
import plotutils
import numpy as np
import os, sys, getopt
import re
from WindReconstruction import makeAnimations

host = '132.247.103.143'
port = 22
inputFolder = '/data/WIND_CUBE/' 
outputFolder = 'images'
ftp = FTP() 
ftp.connect(host,port)

# This function MUST receive a date in the format 'YYYY-MM-DD' and a Time in the format 0-24
if __name__ == "__main__":

    # Login into the FTP server
    print(ftp.login())


    ftp.quit()
