import json

def loadConfig():
    f = open('config.json')
    data = json.load(f)
    f.close()
    return data