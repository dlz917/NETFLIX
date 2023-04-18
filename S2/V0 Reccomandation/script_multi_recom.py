import sys
import nltk
import pymysql
import subprocess
import pandas as pd
from nltk.corpus import stopwords
from nltk.stem import PorterStemmer
from nltk.stem.wordnet import WordNetLemmatizer
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.metrics.pairwise import cosine_similarity
from recomandation import list_similarity, preprocess_text , calculate_similarity

# Connect to MySQL database
cnxn = pymysql.connect(user="nchoice", password="jenesaispas", host="localhost", database="nchoice")

# Get room and request from command line arguments
salle=sys.argv[1]
requete=sys.argv[2]

#Execute first SQL query to get all users in the same room
users = "select id_us from acceder where code =  " + str(salle) + ";"
users = pd.read_sql(users, cnxn)

merged_resultat = pd.DataFrame()

#Browse all users in the room
for user in users['id_us']:
# Execute first SQL query to get historical data
    historique = "select id_show from regarder where id_us = " + str(user) + ";"
    historique = pd.read_sql(historique, cnxn)
    if historique.empty == False:
        t = historique['id_show'].tolist()
        if len (t) > 1:
            requete_historique = "SELECT show_new.*, GROUP_CONCAT(DISTINCT jouer.id_cast SEPARATOR ',') as cast_ids, GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids,GROUP_CONCAT(DISTINCT etre.id_genre SEPARATOR ',') as genre_ids FROM show_new LEFT JOIN jouer ON jouer.id_show = show_new.id_show LEFT JOIN produire ON produire.id_show = show_new.id_show LEFT JOIN etre ON etre.id_show = show_new.id_show  WHERE show_new.id_show IN {} GROUP BY show_new.id_show; ".format(t)
        else:
            requete_historique = "SELECT show_new.*, GROUP_CONCAT(DISTINCT jouer.id_cast SEPARATOR ',') as cast_ids, GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids,GROUP_CONCAT(DISTINCT etre.id_genre SEPARATOR ',') as genre_ids FROM show_new LEFT JOIN jouer ON jouer.id_show = show_new.id_show LEFT JOIN produire ON produire.id_show = show_new.id_show LEFT JOIN etre ON etre.id_show = show_new.id_show  WHERE show_new.id_show = {} GROUP BY show_new.id_show; ".format(t)
    else:
        continue      

# Execute second SQL query to get filtered films
    films_historiques = pd.read_sql(requete_historique, cnxn)
    films_filtres = pd.read_sql(requete, cnxn)

# Execute functions to calculate similarity
    resultat=calculate_similarity(films_filtres, films_historiques)
    merged_resultat = merged_resultat.append(resultat)


# Send to php script
if merged_resultat.empty == False:
    # Execute function to get the list of recommended films and order by similarity
    merged_resultat = merged_resultat.sort_values(by=['similarity'], ascending=False)
    merged_resultat = merged_resultat['id_show'].tolist()
    subprocess.run(['php', 'contenus1.php', merged_resultat])
else:
    films_filtres = films_filtres['id_show'].tolist()
    subprocess.run(['php', 'contenus1.php',films_filtres])

