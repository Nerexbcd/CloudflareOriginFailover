
def 

    if (speakeasy.totp.verify({
      secret: await db.getNodeToken(socket.handshake.auth.nodeId),
      encoding: 'base32',
      token: socket.handshake.auth.token,
      step: 15,
      digits: 10
    })) { return next(); }

## Maybe Use Hashing for the token instead of one time token