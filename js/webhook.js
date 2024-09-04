// webhook.js

const webhookURL = 'https://discord.com/api/webhooks/1277490071792259155/Kznwpl8U5t3dUTIOuzjaqn8tEBfkW2fTnlqyxf6ORsf_NGHalTDA3q2GGZ081lAFGNk9';

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reseller-form');
    
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(this);
            
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            
            const message = {
                content: `New Reseller Application:\n\n` +
                    `**Discord:** ${data.Discord}\n` +
                    `**Website:** ${data.website}\n` +
                    `**Discord Server:** ${data.discordserver}\n` +
                    `**Region:** ${data.region}\n` +
                    `**Turnover:** ${data.turnover}\n` +
                    `**Previous Work:** ${data['previous-work']}\n` +
                    `**Current Products:** ${data['current-products']}\n` +
                    `**HyperThread Products:** ${data['HyperThread-products']}`
            };
            
            fetch(webhookURL, {
                method: 'POST',
                body: JSON.stringify(message),
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    alert('Your application has been submitted!');
                    form.reset();
                } else {
                    alert('There was a problem submitting your application. Please try again.');
                }
            }).catch(error => {
                alert('There was a problem submitting your application. Please try again.');
            });
        });
    }
});
