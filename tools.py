
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
