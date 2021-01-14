
WAPI.waitNewMessages(false, async (data) => {
    for (let i = 0; i < data.length; i++) {
        //fetch API to send and receive response from server
        let message = data[i];
        body = {};
        body.text = message.body;
        body.type = 'message';
        body.user = message.chatId._serialized;
        //body.original = message;
        if (intents.appconfig.webhook) {
            fetch(intents.appconfig.webhook, {
                method: "POST",
                body: JSON.stringify(body),
                headers: {
                    'Content-Type': 'application/json', 
                }
            }).then((resp) => resp.json()).then(function (response) {
                //response received from server
                console.log(response);
                WAPI.sendSeen(message.chatId._serialized);
                //replying to the user based on response
                if (response && response.length > 0) {
                    response.forEach(itemResponse => {
                        WAPI.sendMessage2(message.chatId._serialized, itemResponse.text);
                        //sending files if there is any 
                        if (itemResponse.files && itemResponse.files.length > 0) {
                            itemResponse.files.forEach((itemFile) => {
                                WAPI.sendImage(itemFile.file, message.chatId._serialized, itemFile.name);
                            })
                        }
                    });
                }
            }).catch(function (error) {
                console.log(error);
            });
        }
        

       




         /* TODO:  We waiting for msg and send back respons from server*/

        
        var url = 'https://testing3.volantinopiu.it/whatsappBot/bot_response/getData.php';
        var getNum = message.chatId.user;
        var getMsg = message.body;
        var formData = new FormData();
        formData.append('num', getNum);
        formData.append('msg', getMsg);
     
        /* Username */
        // console.log(message.chat.contact.pushname);

        console.log(message);
        

                /*TODO: Weather API  */
        
        // if(getMsg == 'tempo' || getMsg == 'Tempo') {
        //     fetch('http://api.weatherapi.com/v1/current.json?key=0fd432da40c84dc1809145310202711&q=Naples', {
        //     method: 'GET'
        // }).then((result) => {
        //     return result.json()
        // }).then((response) => {
        
        //     console.log(respones);
        //     const current = response.current;
        //     let condition = current.condition.text;
        //     if(condition =='Partly cloudy') {
        //         condition = 'Parzialmente Nuovoloso';
        //     }
        //     let weatheMSG = `Certo\nEcco previsione per oggi: ${condition}\nTemperature: ${current.temp_c}`;
        //     WAPI.sendMessage2(message.chatId._serialized, weatheMSG);

        // });
        // }



        /* async fetch call */
        
        async function fetchDataFromServer() {
            const [getDataResponse, dictionaryResponse] = await Promise.all([
                fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }),
                fetch('https://testing3.volantinopiu.it/whatsappBot/bot_response/dictionary.php', {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                })
            ]);

            const getData = await getDataResponse.text();
            const dictionary = await dictionaryResponse.text();
            return {
                getData,
                dictionary
            };
        }

        /* Testing */

        fetchDataFromServer().then(({getData, dictionary }) => {
            function delay() {
                WAPI.sendSeen(message.chatId._serialized);
                return new Promise(resolve => setTimeout(resolve,1000));
            }

            async function delayLog() {
                
                await delay();
                WAPI.sendMessage2(message.chatId._serialized, getData);

            }
            delayLog();
        //    WAPI.sendMessage2(message.chatId._serialized, getData);
        //    WAPI.sendMessage2(message.chatId._serialized, dictionary);
        });


        /* Old sync version fetch*/
        
       
          /*   fetch(url, {method: 'POST', body: formData, mode: 'cors'})
                .then(function(response) {
                    return response.text();
                }).then(function(body) {
                    let result = body;
                   
                    WAPI.sendMessage2(message.chatId._serialized, result);
                    

                   
                });
               */



        
        window.log(`Message from ${message.chatId.user} checking..`);
        if (intents.blocked.indexOf(message.chatId.user) >= 0) {
            window.log("number is blocked by BOT. no reply");
            return;
        }
        if (message.type == "chat") {
            //message.isGroupMsg to check if this is a group
            if (message.isGroupMsg == true && intents.appconfig.isGroupReply == false) {
                window.log("Message received in group and group reply is off. so will not take any actions.");
                return;
            }
            var exactMatch = intents.bot.find(obj => obj.exact.find(ex => ex == message.body.toLowerCase()));
            var response = "";
            if (exactMatch != undefined) {
                response = await resolveSpintax(exactMatch.response);
                window.log(`Replying with ${response}`);
            } else {
                response = await resolveSpintax(intents.noMatch);
                window.log(`No exact match found. So replying with ${response} instead`);
            }
            var PartialMatch = intents.bot.find(obj => obj.contains.find(ex => message.body.toLowerCase().search(ex) > -1));
            if (PartialMatch != undefined) {
                response = await resolveSpintax(PartialMatch.response);
                window.log(`Replying with ${response}`);
            } else {
                console.log("No partial match found");
            }
            /* FIXME: */

            
            function delay() {
                WAPI.sendSeen(message.chatId._serialized);
                return new Promise(resolve => setTimeout(resolve,1200));
            }

            async function delayLog() {
                
                await delay();
                WAPI.sendMessage2(message.chatId._serialized, response);

            }

            async function ReturnPromise() {
                await delayLog();
               
               
                window.log("Return promise with 3 second pause");

            }
            ReturnPromise();

           
         
            if ((exactMatch || PartialMatch).file != undefined) {
                files = await resolveSpintax((exactMatch || PartialMatch).file);
                window.getFile(files).then((base64Data) => {
                    //console.log(file);
                    WAPI.sendImage(base64Data, message.chatId._serialized, (exactMatch || PartialMatch).file);
                }).catch((error) => {
                    window.log("Error in sending file\n" + error);
                })
            }
        }
    }
});


WAPI.addOptions = function () {
    var suggestions = "";
    intents.smartreply.suggestions.map((item) => {
        suggestions += `<button style="background-color: #eeeeee;
                                margin: 5px;
                                padding: 5px 10px;
                                font-size: inherit;
                                border-radius: 50px;" class="reply-options">${item}</button>`;
    });
    var div = document.createElement("DIV");
    div.style.height = "40px";
    div.style.textAlign = "center";
    div.style.zIndex = "5";
    div.innerHTML = suggestions;
    div.classList.add("grGJn");
    var mainDiv = document.querySelector("#main");
    var footer = document.querySelector("footer");
    footer.insertBefore(div, footer.firstChild);
    var suggestions = document.body.querySelectorAll(".reply-options");
    for (let i = 0; i < suggestions.length; i++) {
        const suggestion = suggestions[i];
        suggestion.addEventListener("click", (event) => {
            console.log(event.target.textContent);
            window.sendMessage(event.target.textContent).then(text => console.log(text));
        });
    }
    mainDiv.children[mainDiv.children.length - 5].querySelector("div > div div[tabindex]").scrollTop += 100;
}
