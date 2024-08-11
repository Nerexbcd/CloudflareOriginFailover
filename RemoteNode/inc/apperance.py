class bcolors:
    PURPLE = '\033[95m'
    BLUE = '\033[94m'
    CYAN = '\033[96m'
    GREEN = '\033[92m'
    YELLOW = '\033[93m'
    RED = '\033[91m'
    ENDC = '\033[0m'
    BOLD = '\033[1m'
    UNDERLINE = '\033[4m'

def print_PURPLE(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.PURPLE}{msg}{bcolors.ENDC}")

def print_BLUE(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.BLUE}{msg}{bcolors.ENDC}")

def print_CYAN(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.CYAN}{msg}{bcolors.ENDC}")

def print_GREEN(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.GREEN}{msg}{bcolors.ENDC}")

def print_YELLOW(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.YELLOW}{msg}{bcolors.ENDC}")

def print_RED(msg, UNDERLINE=False):
    if UNDERLINE:
        msg = bcolors.UNDERLINE+msg
    print(f"{bcolors.RED}{msg}{bcolors.ENDC}")

def print_DEMO():
    print_PURPLE("Hello World!")
    print_PURPLE("Hello World!",True)

    print_BLUE("Hello World!")
    print_BLUE("Hello World!",True)

    print_CYAN("Hello World!")
    print_CYAN("Hello World!",True)

    print_GREEN("Hello World!")
    print_GREEN("Hello World!",True)

    print_YELLOW("Hello World!")
    print_YELLOW("Hello World!",True)

    print_RED("Hello World!")
    print_RED("Hello World!",True)
