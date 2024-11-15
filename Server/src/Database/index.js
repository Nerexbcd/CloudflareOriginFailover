const { PrismaClient } = require('@prisma/client')

// ------------ Database ------------ //
module.exports = class DataBase {
    #database;
    constructor() {
        // Prepare Database Connection and Functions
        this.#database = new PrismaClient().$connect({
            datasources: {
                db: {
                    url: "file:src/Database/Central.db",
                },
            },
        });

        
        // this.namespaces = new (require('./namespaces'))(this.#database)
    }

    // ------------ Database Connection ------------ //
    // connect() {
    //     this.#database.connect(function(err) {
    //         if (err) {
    //             console.error('Database error connecting: ' + err.stack);
    //             exit(1);
    //         }
    //         console.log('Connected to database');
    //     });
    // }

    // ------------ Global Database Functions ------------ //

    // Reset Nodes Registred Connection
    // resetNodes() {
    //     this.#database.query('UPDATE RunningNodes SET connected = 0 WHERE connected = 1');
    // }


    
}