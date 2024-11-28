const { Client, GatewayIntentBits } = require('discord.js');
require('dotenv').config();

const client = new Client({ intents: [GatewayIntentBits.Guilds] });

client.once('ready', () => {
    console.log(`Logged in as ${client.user.tag}`);
});

client.on('messageCreate', message => {
    if (message.content === '!send') {
        const channel = client.channels.cache.get('1280213741169807416'); // Replace with your channel ID
        if (channel) {
            channel.send('Hello from your Discord bot!');
        }
    }
});

client.login(process.env.BOT_TOKEN);
