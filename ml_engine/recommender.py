import mysql.connector
import pandas as pd
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.metrics.pairwise import cosine_similarity

# 1. Connect to the Database
try:
    db = mysql.connector.connect(
        host="localhost",
        user="root",          
        password="",          
        database="bookstore"  
    )
    
    # Fetch books from your Laravel database
    query = "SELECT id, title, author FROM books"
    books_df = pd.read_sql(query, db)
    
    if books_df.empty:
        print("❌ No books found in the database. Please add some books in your Laravel admin panel first!")
        exit()

    print("✅ Database Connected. Training AI...")

    # 2. Prepare the Data
    # Combine the title and author into a single 'tags' column for the AI to read
    books_df['tags'] = books_df['title'] + " " + books_df['author']

    # 3. Train the Model
    # Convert the text tags into a matrix of numbers
    vectorizer = TfidfVectorizer(stop_words='english')
    feature_matrix = vectorizer.fit_transform(books_df['tags'])

    # Calculate the similarity score between every single book
    similarity = cosine_similarity(feature_matrix)

    # 4. Create the Recommendation Function
    def recommend_books(book_title, num_recommendations=3):
        # Find the index of the book the user is looking at
        try:
            book_index = books_df[books_df['title'] == book_title].index[0]
        except IndexError:
            return f"❌ Book '{book_title}' not found in database."

        # Get the similarity scores for that specific book
        distances = similarity[book_index]

        # Sort the books by highest similarity score (excluding the book itself)
        # [::-1] reverses the list so the highest matches are at the top
        books_list = sorted(list(enumerate(distances)), reverse=True, key=lambda x: x[1])[1:num_recommendations+1]

        print(f"\n📚 Because you liked '{book_title}', you might also love:")
        print("-" * 50)
        
        for i in books_list:
            recommended_id = books_df.iloc[i[0]].id
            recommended_title = books_df.iloc[i[0]].title
            recommended_author = books_df.iloc[i[0]].author
            match_percentage = round(i[1] * 100, 2)
            
            print(f"ID {recommended_id}: {recommended_title} by {recommended_author} ({match_percentage}% match)")

    # --- TEST IT OUT ---
    # Try recommending books similar to the first book in your database
    first_book_title = books_df.iloc[0]['title']
    recommend_books(first_book_title)

except Exception as e:
    print(f"❌ Error: {e}")