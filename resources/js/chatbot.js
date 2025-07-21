async function getAIResponse(message) {
    try {
        const response = await fetch('/api/ask-openai', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        });
        
        const data = await response.json();
        return data.choices[0].message.content;
        
    } catch (error) {
        console.error("Error:", error);
        return "⚠️ Error al conectar con el servicio. Intenta más tarde.";
    }
}