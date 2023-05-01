import pandas as pd
import nltk
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
from nltk.stem.wordnet import WordNetLemmatizer
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import cosine_similarity

def list_similarity(list1, list2):
    if (list1 is None or list2 is None) or (len(list1) == 0 or len(list2) == 0):        
        return 0
    
    set1 = set(map(tuple, list1))
    set2 = set(map(tuple, list2))

    intersection = set1.intersection(set2)
    union = set1.union(set2)

    similarity = len(intersection) / len(union) 
    return similarity

def preprocess_text(text):
    # Remove stop words
    stop_words = set(stopwords.words("english"))
    filtered_text = [word for word in text.lower().split() if word not in stop_words]
    
    # Perform stemming
    ps = PorterStemmer()
    stemmed_text = [ps.stem(word) for word in filtered_text]
    
    # Perform lemmatization
    lem = WordNetLemmatizer()
    lemmatized_text = [lem.lemmatize(word, "v") for word in stemmed_text]
    
    return " ".join(lemmatized_text)

def calculate_similarity(filtres, historique):
    genre_weight = 0.2
    director_weight = 0.15
    cast_weight = 0.20
    type_weight = 0.05
    description_weight = 0.3
    year_weight = 0.05
    country_weight = 0.05
    # Create a copy of the dataframes
    filtres_similarity = filtres.copy()
    historique_similarity = historique.copy()
    
    #Preprocess the  lists columns
    filtres_similarity["cast_ids"]=filtres_similarity["cast_ids"].str.split(",")
    filtres_similarity["director_ids"]=filtres_similarity["director_ids"].str.split(",")
    filtres_similarity["genre_ids"]=filtres_similarity["genre_ids"].str.split(",")
    filtres_similarity["country"]=filtres_similarity["country"].str.split(",")

    historique_similarity["cast_ids"]=historique_similarity["cast_ids"].str.split(",")
    historique_similarity["director_ids"]=historique_similarity["director_ids"].str.split(",")
    historique_similarity["genre_ids"]=historique_similarity["genre_ids"].str.split(",")
    historique_similarity["country"]=historique_similarity["country"].str.split(",")

    # Preprocess the description column
    filtres_similarity['description'] = filtres_similarity['description'].apply(preprocess_text)
    historique_similarity['description'] = historique_similarity['description'].apply(preprocess_text)

    #Acces rows of the filtered films dataframe and calculate the similarity between every filtered film and the films in the historial
    df_similarity = pd.DataFrame(columns=['id_show', 'similarity'])
    for index, row in filtres_similarity.iterrows():
        similarity=0
        for index2, row2 in historique_similarity.iterrows():
            if row['type']==row2['type']:
                similarity+=1*type_weight
            if row['year']==row2['year']:
                similarity+=1*year_weight
            similarity+=list_similarity(row['genre_ids'],row2['genre_ids'])*genre_weight
            similarity+=list_similarity(row['director_ids'],row2['director_ids'])*director_weight
            similarity+=list_similarity(row['cast_ids'],row2['cast_ids'])*cast_weight
            similarity+=list_similarity(row['country'],row2['country'])*country_weight
            vectorizer = CountVectorizer()
            # Transform the descriptions into vectors
            vectors = vectorizer.fit_transform([row["description"], row2["description"]])
            # Calculate the cosine similarity between the two vectors
            cosine_sim = cosine_similarity(vectors[0], vectors[1])[0][0]
            similarity+=cosine_sim*description_weight

        new_row={'id_show':row['id_show'],'similarity':similarity/len(historique_similarity)}
        df_similarity=df_similarity.append(new_row, ignore_index=True)

   

    return df_similarity.sort_values(by=['similarity'], ascending=False)