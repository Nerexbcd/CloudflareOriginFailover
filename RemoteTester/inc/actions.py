import requests

def testOrigin(originURL):
    try:
        response = requests.post(originURL)
        if response.status_code == 200:
            return True
        else:
            return False
    except:
        return False