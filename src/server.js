const express = require('express')
const ejs = require('ejs')
const path = require('path')
const app = express()

const passengers = [
    {
        name: "Joyce",
        flightNumber: 7859,
        time: "18h00",
    },
    {
        name: "Brock",
        flightNumber: 7859,
        time: "18h00",
    },
    {
        name: "Eve",
        flightNumber: 7859,
        time: "18h00",
    },
]

app.get('/', (request, response) => {

    const filePath = path.join(__dirname, "./", "src", "print.ejs")
    ejs.renderFile(filePath,{passengers}, (err,data) => {
        if(err){
            return response.send('Erro na leitura do aquivo')
        }

        return response.send(data)
    })
})

app.listen(3000)