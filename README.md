## Lückentext

### Format

Eine Lücke wird durch doppelte eckige Klammern `[[` und `]]` gekennzeichnet. Darin muss das Wort stehen, das die richtige Antwort für diese Lücke ist.

Jede Lücke benötigt einen zusätzlichen Kontext, der für die Beantwortung der Lücke entscheidend ist. Dieser Kontext wird zwischen doppelten geschweiften Klammern `{{` und `}}` angegeben. Dadurch wird der gesamte Text vor und / oder nach den eckigen Klammern als
zusätzliche Beschreibung für die eigentliche Lücke verwendet.

**Wichtig:** Für jeden Lückentext muss der eigentliche Inhalt innerhalb einer Lücke (zwischen den eckigen Klammern) eindeutig sein! Das gleiche Wort in mehreren Lücken ist nicht zulässig. Beim Inhalt der Lücken wird zwischen Groß- und Kleinschreibung unterschieden, also sind „abc“ und „ABC“ nicht dasselbe.
Führende oder nachfolgende Leerzeichen um den Lückeninhalt werden ignoriert.

**Beispiel: Lücke mit zusätzlichem Kontext**
```
Es gibt viele Sterne am Himmel. {{Der Stern, der uns am nächsten ist, ist unsere eigene Sonne. Danach kommt [[Alpha Centauri]]. 
Er ist einer der berühmtesten Sterne der Popkultur.}}
```

**Beispiel: Mehrere Absätze**
```
{{Dies ist der erste [[Absatz]].}}

{{Dies ist der [[zweite]] Absatz.}}
```

### Punkte

Für jeden Lückentext muss die Anzahl der Punkte pro Lücke sowie ein Punkte-Multiplikator angegeben werden. Falls die Punktzahl nicht multipliziert werden soll, ist es ausreichend, die 1 in dem Feld stehenzulassen. Die Zahlen können bis zu 2 Nachkommastellen haben. Die mögliche Gesamtpunktzahl wird automatisch berechnet.

### Lücken-Datensätze

Für jede Lücke muss ein eigener Datensatz innerhalb des Lückentextes angelegt werden. Dort müssen Pflicht-Informationen zur Lücke wie Nummerierung, richtiger Antwort und alle Antwortoptionen eingetragen werden. Zusätzlich gibt es die Möglichkeit, eine Lücke als Beispiel zu hinterlegen. 

