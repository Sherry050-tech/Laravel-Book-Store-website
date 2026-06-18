# Bookstore E-Commerce Platform with ML Recommendation Engine

A full-stack e-commerce application featuring a microservice architecture that integrates a standard web backend with a dedicated machine learning service. The platform provides a complete shopping experience, an administrative dashboard, and dynamically generated, personalized content recommendations.

## System Architecture

The application is split into two primary services communicating via internal HTTP requests:

1. **Core Web Application (Laravel/PHP)**
   Handles the primary user interface, database management, user authentication, shopping cart logic, order processing, and the administrative control panel.
   
2. **Recommendation Microservice (Flask/Python)**
   A lightweight API dedicated exclusively to data processing and machine learning calculations, ensuring heavy mathematical operations do not block the main web server.

## Tech Stack

* **Frontend:** Blade Templates, HTML5, CSS3 (Custom Responsive Grid)
* **Backend:** PHP 8.x, Laravel 11.x
* **Machine Learning API:** Python 3.x, Flask, Scikit-Learn, Pandas, NumPy
* **Database:** MySQL

## Machine Learning Implementation

The recommendation engine utilizes a Content-Based Filtering approach to match books based on textual metadata (Title and Author). 

* **Vectorization:** Book metadata is ingested and transformed into a mathematical matrix using `TfidfVectorizer`, weighting unique identifying words while stripping common stop words.
* **Similarity Scoring:** The engine calculates the angle between data points using `cosine_similarity`. 
* **Integration Points:** * *Product Pages:* Queries the target book against the matrix to return the nearest neighbors.
  * *User Dashboard/Feed:* Queries the most recent item in a user's authenticated order history to generate a personalized feed of mathematically similar titles.

## Local Setup & Installation

### Prerequisites
* PHP >= 8.2 and Composer
* Python >= 3.10
* MySQL server

### 1. Database Configuration
1. Start your local MySQL server.
2. Create an empty database named `bookstore`.

### 2. Core Application Setup (Laravel)
Navigate to the root directory of the project and run the following commands to install dependencies, configure the environment, and seed the database:

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve

3. Recommendation API Setup (Flask)
Open a new terminal window, navigate to the machine learning directory, and start the API service:
cd ml_engine
python -m venv venv

# Activate virtual environment
# On Windows: .\venv\Scripts\activate
# On macOS/Linux: source venv/bin/activate

pip install -r requirements.txt
python api.py
The API will run continuously on http://127.0.0.1:5000 and listen for incoming requests from the Laravel application
