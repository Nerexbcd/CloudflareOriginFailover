import requests

# def processError(response):
#     if response.status_code != 200:
#         return True
#     else:
#         return False



def getRuleSet(zoneID, ruleSetID, token):
    url = 'https://api.cloudflare.com/client/v4/zones/'+zoneID+'/rulesets/'+ruleSetID
    try:
        response = requests.get(url=url, headers={'Authorization': 'Bearer '+token})
        if response.status_code == 200:
            return response.json()['result']
        else:
            print('Error:', response.status_code)
            return False
    except:
        return False

def createRule(zoneID, ruleSetID, rule, token):
    url = 'https://api.cloudflare.com/client/v4/zones/'+zoneID+'/rulesets/'+ruleSetID+'/rules'

    try:
        # Make a GET request to the API endpoint using requests.get()
        response = requests.post(url=url, json=rule, headers={'Authorization': 'Bearer '+token, 'Content-Type': 'application/json'})

        # Check if the request was successful (status code 200)
        if response.status_code == 200:
            return response.json()['result']
        else:
            print('Error:', response.status_code)
            #### TO REMOVE
            return response.json() 
            
            #return None

    except:
        return False
    
def deleteRule(zoneID, ruleSetID, ruleID, token):
    url = 'https://api.cloudflare.com/client/v4/zones/'+zoneID+'/rulesets/'+ruleSetID+'/rules/'+ruleID

    try:
        response = requests.delete(url=url, headers={'Authorization': 'Bearer '+token})
        if response.status_code == 200:
            return True
        else:
            print('Error:', response.status_code)
            return False
    except:
        return False
    
def updateRule(zoneID, ruleSetID, ruleID, rule, token):
    url = 'https://api.cloudflare.com/client/v4/zones/'+zoneID+'/rulesets/'+ruleSetID+'/rules/'+ruleID

    try:
        response = requests.patch(url=url, headers={'Authorization': 'Bearer '+token})
        if response.status_code == 200:
            return True
        else:
            print('Error:', response.status_code)
            return False
    except:
        return False