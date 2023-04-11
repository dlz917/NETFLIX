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

cnxn = pymysql.connect(user="nchoice", password="jenesaispas", host="localhost", database="nchoice")

user=sys.argv[1]
requete=sys.argv[2]

historique = "select id_show from regarder where id_us = " + str(user) + ";"
t = historique['id_show'].tolist()
requete_historique = "SELECT show_new.*, GROUP_CONCAT(DISTINCT jouer.id_cast SEPARATOR ',') as cast_ids, GROUP_CONCAT(DISTINCT produire.id_direc SEPARATOR ',') as director_ids,GROUP_CONCAT(DISTINCT etre.id_genre SEPARATOR ',') as genre_ids FROM show_new LEFT JOIN jouer ON jouer.id_show = show_new.id_show LEFT JOIN produire ON produire.id_show = show_new.id_show LEFT JOIN etre ON etre.id_show = show_new.id_show  WHERE show_new.id_show IN {} GROUP BY show_new.id_show; ".format(t)

films_historiques = pd.read_sql(requete_historique, cnxn)
films_filtres = pd.read_sql(requete, cnxn)

resultat=calculate_similarity(films_filtres, films_historiques)

id_list = resultat['id_show'].tolist()

subprocess.run(['php', '?¿?.php', id_list])


