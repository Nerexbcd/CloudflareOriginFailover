# Cloudflare Origin Failover Central Server
This Folder stores the code for the COF Central Server.
This section of the project is the one that interconnects all parts and interfaces with Cloudflare API.

> [!WARNING]
> IN DEVELOMPENT

> [!Note]
> This Section of the Service is based in [Socket.io](https://socket.io/), meaning that it will need to be exposed by a domain/subdomain (could be vercel's one or your own), to be accessed by the other parts of the Service!


> [!IMPORTANT]
> This Section of the Service is being prepared to be run on [Vercel](https://vercel.com/), as it is **the only one that cannot fail**, due to being the the communication server for all parts, and **if it fails the hole Service won't work !!**

## Service Exposed Ports:
 - Communication Server Port -> `:3000`
 - Metrics Server Port -> `:9090`

> [!WARNING]
> Some files might be missing from this repository because it can have some authenticatian credentials or secrets that cannot be shared.
