const express = require('express');
const cors = require('cors');
const axios = require('axios');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json());

// Example API endpoint
app.get('/api/health', (req, res) => {
  res.json({ status: 'ok', message: 'Node.js API server is running' });
});

// Example endpoint for external API integration
app.get('/api/external-data', async (req, res) => {
  try {
    // This is just an example - replace with your actual external API integration
    const response = await axios.get('https://jsonplaceholder.typicode.com/posts');
    res.json(response.data);
  } catch (error) {
    console.error('Error fetching external data:', error);
    res.status(500).json({ error: 'Failed to fetch external data' });
  }
});

app.listen(PORT, () => {
  console.log(`Node.js API server running on port ${PORT}`);
}); 