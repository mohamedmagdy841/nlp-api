<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel NLP API Project

This is a Laravel-based API application that uses NLP (Natural Language Processing) services to provide advanced text-processing features, including summarization, translation, sentiment analysis, and named entity recognition. The project leverages caching with Redis to optimize performance by reducing repeated API calls and is fully containerized with Docker for consistent deployment across different environments.

## Features

- **Redis Caching**: Frequently requested data is cached with Redis to reduce external API requests and improve response time.
- **Model-Specific Processing**: Support for multiple NLP models to handle tasks like text summarization, translation, sentiment analysis, and entity recognition.
- **Dockerized Application**: The application is containerized with Docker, ensuring consistency across all environments.
- **Rate Limiting**: Configured to manage request rates, enhancing security and preventing excessive API calls.

## Example

An example of a translation request to convert text to Arabic:

**Input:**

```json
{
    "text": "Traveling opens your mind to new cultures and experiences. It allows you to meet people from different backgrounds, taste unique foods, and understand the world in a new way. Traveling also helps you appreciate what you have and teaches you to be adaptable."
}
```

**Output:**

```json
{
    "state": 200,
    "message": "Data cached successfully",
    "data": "السفر يفتح عقلك لثقافات وتجارب جديدة. يسمح لك بمقابلة أشخاص من خلفيات مختلفة ، وتذوق الأطعمة الفريدة ، وفهم العالم بطريقة جديدة. يساعدك السفر أيضًا على تقدير ما لديك ويعلمك التكيف."
}
```

## Technologies and Tools

- **Laravel 11**: Used as the core framework for routing, controllers, and middleware.
- **Redis**: Caches NLP data to improve performance and reduce repeated calls to external APIs.
- **Docker & Docker Compose**: Containerizes the entire application for consistent environment setup.
- **NLP Cloud API**: Integrates advanced NLP capabilities, using model-specific methods.
- **Postman**: Simplifies testing API endpoints.
- **Postman Documentation** [here](https://documenter.getpostman.com/view/38857071/2sAY4vhhuT) 

## Installation

### Prerequisites

- Docker
- Docker Compose
- Composer
- PHP 8.2

### Steps

1. **Clone the repository:**

    ```bash
    git clone https://github.com/mohamedmagdy841/nlp-api.git
    ```

2. **Navigate to the project directory:**

    ```bash
    cd nlp-api
    ```

3. **Copy `.env.example` to `.env` and configure environment variables (API keys, Redis settings):**

    ```bash
    cp .env.example .env
    ```

4. **Build and start Docker containers:**

    ```bash
    docker-compose up --build
    ```

5. **Access the application at `http://localhost:8080`.**

## Docker and Redis

The project is fully containerized using Docker and Docker Compose, enabling consistent deployment. Redis is included for caching purposes, reducing load on the NLP API and enhancing performance.
<p align="center"><a href="https://www.docker.com" target="_blank"><img src="https://github.com/user-attachments/assets/b6fcf59c-9532-477b-a030-8e54d939d456" width="300" alt="Docker Logo"></a></p>
<p align="center"><a href="https://redis.io" target="_blank"><img src="https://github.com/user-attachments/assets/454b1985-6723-4448-a127-827c6b12a3c0" width="300" alt="Redis Logo"></a></p>

## Project Demo

- **Before caching**: Response times can take several seconds.
- **After caching**: Response times drop to just milliseconds.

https://github.com/user-attachments/assets/b1121ea2-da9b-4e54-8de4-1dc488e6d130

