document.getElementById('applicationForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const age = document.getElementById('age').value;
    const message = document.getElementById('message').value;

    const webhookUrl = 'https://discord.com/api/webhooks/1253606165078605935/bIxDRE5K-IPPEL9UkSFy0kpm-iGsTpx9qH1IqQTyy2FVEwiLA9CVutyVNVIfEYGLt7Ou';

    const payload = {
        content: "New Application Received",
        embeds: [{
            title: "Application Details",
            fields: [
                { name: "Name", value: name, inline: true },
                { name: "Email", value: email, inline: true },
                { name: "Age", value: age, inline: true },
                { name: "Message", value: message, inline: false }
            ]
        }]
    };

    fetch(webhookUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (response.ok) {
            alert('Application submitted successfully!');
        } else {
            return response.text().then(text => { throw new Error(text); });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to submit application: ' + error.message);
    });
});
