const express = require('express');
const axios = require('axios');
const googleTTS = require('google-tts-api');
const cors = require('cors');
const fs = require('fs');
const path = require('path');

const app = express();
app.use(express.json());
app.use(cors());
const PORT = 3000;

// Translation endpoint
app.post('/translate', async (req, res) => {
    const { text, sourceLang, targetLang } = req.body;
    try {
        const response = await axios.post('https://libretranslate.com/translate', {
            q: text,
            source: sourceLang,
            target: targetLang,
            format: "text"
        });
        res.json({ translatedText: response.data.translatedText });
    } catch (error) {
        res.status(500).json({ error: 'Translation failed' });
    }
});

// Text-to-Speech endpoint
app.post('/tts', async (req, res) => {
    const { text, language, repeat } = req.body;
    try {
        const url = googleTTS.getAudioUrl(text, {
            lang: language,
            slow: false,
            host: 'https://translate.google.com',
        });
        
        // Download and repeat audio
        const filePath = path.join(__dirname, 'public', 'translated_audio.mp3');
        const response = await axios.get(url, { responseType: 'stream' });
        const writer = fs.createWriteStream(filePath);
        response.data.pipe(writer);
        writer.on('finish', () => res.json({ fileUrl: `/download` }));
        writer.on('error', (err) => res.status(500).json({ error: 'TTS failed' }));
    } catch (error) {
        res.status(500).json({ error: 'TTS failed' });
    }
});

// Audio download endpoint
app.get('/download', (req, res) => {
    const filePath = path.join(__dirname, 'public', 'translated_audio.mp3');
    res.download(filePath);
});

app.listen(PORT, () => console.log(`Server running on http://localhost:${PORT}`));

