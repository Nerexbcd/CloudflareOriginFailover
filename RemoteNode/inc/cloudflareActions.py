def createRule(failoverURL, excludedURLs, Enabled):
    expression = "(not http.host in {"
    for url in excludedURLs:
        expression += '\"' + url + '\" '
    expression += '})'

    rule = {
        "action": "redirect",
        "expression": expression,
        "description": "AUTO | COF | Failover Rule",
        "enabled": Enabled,
        "action_parameters": {
            "from_value": {
                "status_code": 307,
                "target_url": {
                    "value": failoverURL
                },
                "preserve_query_string": False
            }
        }
    }

    return rule

def processRuleSet(ruleSet):
    rules = {}
    for rule in ruleSet['rules']:
        rules[rule['id']] = rule['description']
    return rules