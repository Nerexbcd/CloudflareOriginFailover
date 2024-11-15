from inc.apperance import *
from inc.loadConfig import loadConfig
import inc.actions as actions
import inc.cloudflareActions as cloudflareActions
import inc.cloudflareAPI as cloudflareAPI

import time
import signal
import sys
# ------------------ App Setup ------------------ #
# \\\\ Variables
currentRuleID = ""

# \\\\ Exit Handler
def signal_handler(signal, frame):
    print_YELLOW('\n\nYou pressed Ctrl+C - or killed me with -2\nApp Terminating...')
    if currentRuleID != "":
        cloudflareAPI.deleteRule(config['Cloudflare']['ZoneID'], config['Cloudflare']['RuleSetID'], currentRuleID, config['Cloudflare']['Token'])
        print_GREEN('Rule created by the app deleted')
    else:
        print_CYAN('No rule was setup until Termination of the App')
    print_GREEN('App Terminated')
    sys.exit(0)

# \\\\ Set the Exit Signal Handler
signal.signal(signal.SIGINT, signal_handler)

# ----------------- Load Config ----------------- #
print_CYAN('Loading Config...')

try:
    config = loadConfig()
except:
    print_RED('Error: Config File was not Loaded')
    print_RED('App Terminating...')
    sys.exit(0)

if 'https://' not in config['OriginNodeURL'] and 'http://' not in config['OriginNodeURL']:
    config['OriginNodeURL'] = 'https://'+config['OriginNodeURL']

if 'https://' not in config['FailoverURL'] and 'http://' not in config['FailoverURL']:
    config['FailoverURL'] = 'https://'+config['FailoverURL']

config['ExcludedURLs'].append(config['OriginNodeURL'].replace('https://', '').replace('http://', ''))
config['ExcludedURLs'].append(config['FailoverURL'].replace('https://', '').replace('http://', ''))

print_GREEN('Config Loaded')

# ----------------- App Startup ----------------- #
print_CYAN('Starting App...')

# \\\\ Get the current rule set
print_CYAN('Getting the current rule set...')
rulesIDs = cloudflareActions.processRuleSet(cloudflareAPI.getRuleSet(config['Cloudflare']['ZoneID'], config['Cloudflare']['RuleSetID'], config['Cloudflare']['Token']))

# \\\\ Delete all rules related to this app (if there are any already)
print_CYAN('Checking for Old Rules related to this app...')
oldRuleExists = False
for key in rulesIDs:
    if 'AUTO | COF | Failover Rule' in rulesIDs[key]:
        oldRuleExists = True
        cloudflareAPI.deleteRule(config['Cloudflare']['ZoneID'], config['Cloudflare']['RuleSetID'], key, config['Cloudflare']['Token'])

if oldRuleExists:
    print_YELLOW('One or More Old Rules related to this app ware deleted')
else:
    print_GREEN('No Old Rules related to this app ware found')

# \\\\ Prepare the rule
rule = cloudflareActions.createRule(config['FailoverURL'], config['ExcludedURLs'], false)

# \\\\ Create the rule
print_CYAN('Creating the new rule...')
createdRuleResponse = cloudflareAPI.createRule(config['Cloudflare']['ZoneID'], config['Cloudflare']['RuleSetID'], rule, config['Cloudflare']['Token'])

# \\\\ Find the ID of the newly created rule
afterRulesIDs = cloudflareActions.processRuleSet(createdRuleResponse)

for key in rulesIDs:
    afterRulesIDs.pop(key, None) 

try:
    currentRuleID = list(afterRulesIDs.keys())[0]
    print_GREEN('Rule created Successfully for the app')
except:
    print_RED('Error: Rule was not created for the app')
    print_RED('App Terminating...')
    sys.exit(0)



# ------------------ Main Loop ------------------ #
while True:
    print(actions.testOrigin(config['OriginNodeURL']))
    time.sleep(config['CheckInterval'])


### TO DO
# create enabled rule : cloudflareActions.createRule(config['FailoverURL'], config['ExcludedURLs'], false)
# send enabled rule : cloudflareAPI.createRule(config['Cloudflare']['ZoneID'], config['Cloudflare']['RuleSetID'], rule, config['Cloudflare']['Token'])
# and viseversa

# also add the ability to update the rule and add an extra rule for on porpuse maintenance page

# add sync token system
# add control panel in the origin node
# create the origin node
# make both nodes avaliable in docker