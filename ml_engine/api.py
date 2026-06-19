from flask import Flask, request, jsonify
import mysql.connector
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

app = Flask(__name__)

print("⚙️ Initializing AI Engine...")

# 1. Connect to DB and Train the Model ONCE when the server starts
try:
    db = mysql.connector.connect(
        host="localhost",
        user="root",          
        password="",          
        database="bookstore"  
    )
    
    query = "SELECT id, title, author FROM books"
    books_df = pd.read_sql(query, db)
    books_df['tags'] = books_df['title'] + " " + books_df['author']
    
    vectorizer = TfidfVectorizer(stop_words='english')
    feature_matrix = vectorizer.fit_transform(books_df['tags'])
    similarity = cosine_similarity(feature_matrix)
    
    print("✅ AI Engine Ready and Waiting for Laravel...")

except Exception as e:
    print(f"❌ Startup Error: {e}")


# 2. Create the API Endpoint
@app.route('/recommend', methods=['GET'])
def get_recommendations():
    # Grab the book title Laravel sends us in the URL
    book_title = request.args.get('title')
    
    if not book_title:
        return jsonify({"error": "No title provided"}), 400

    try:
        # Find the book
        book_index = books_df[books_df['title'] == book_title].index[0]
        distances = similarity[book_index]
        
        # Get top 3 matches
        books_list = sorted(list(enumerate(distances)), reverse=True, key=lambda x: x[1])[1:4]
        
        # Format the results as JSON so Laravel can easily read it
        recommendations = []
        for i in books_list:
            match_score = round(i[1] * 100, 2)
            # Only recommend if there is actually some similarity (> 0%)
            if match_score > 0:
                recommendations.append({
                    "id": int(books_df.iloc[i[0]].id),
                    "title": books_df.iloc[i[0]].title,
                    "author": books_df.iloc[i[0]].author,
                    "match": match_score
                })
                
        return jsonify(recommendations)

    except IndexError:
        return jsonify({"error": "Book not found"}), 404
    except Exception as e:
        return jsonify({"error": str(e)}), 500


# 3. Run the Server
if __name__ == '__main__':
    # Runs the server on port 5000
    app.run(port=5000, debug=True)