# Release Notes für Amazon Pay

## 1.5.2

### Gefixt

- Access Token Erkennung in Redirect

## 1.5.1

### Gefixt

- besseres URL Handling (Sprach-Präfix)
- zuverlässigere Übertragung der OrderReference
- Shopware Connector - Status setzen

## 1.5.0

### Hinzugefügt

- optionales Hinzufügen der E-Mail-Adresse zur Versandadresse 

### Gefixt

- IPN - Hinzufügen von abgelaufenen Autorisierungstransaktionen entfernt
- URL-Generierung 

## 1.4.1

### Gefixt

- Kaufabbruch wegen fehlender Rechnungsadresse
- sich überlagernde Ajax-Calls
- Abhängigkeiten aktualisiert

## 1.4.0

### Hinzugefügt

- Multi Faktor Authentifizierung (nach PSD2)

## 1.3.1

### Hinzugefügt

- Erkennung von externen Captures (z.B. in Seller Central)

### Gefixt

- diverse IPN-/Transaktionsprobleme

## 1.3.0

### Hinzugefügt

- Kompatibilität mit Shopware Connector

### Gefixt

- Verlust von Access Token aus Session

## 1.2.2

### Gefixt

- Netto-Bestellungen

## 1.2.1

### Gefixt

- Fehler in Ereignisaktion für Zahlungseinzug
- JS: scope für alle Widgets

## 1.2.0

### Hinzugefügt

- Shopware Anbindung für Transaktionen (Testphase)

### Gefixt

- richtige Sprache für Buttons
- Beschriftung "Kaufen"-Button
- Warenkorb-Button bei nicht verfügbaren Varianten verstecken

## 1.1.6

### Gefixt

- Ausführungsreihenfolge JS, weil Click-Event sporadisch nachträglich von Vue entfernt wurde

## 1.1.5

### Hinzugefügt

- Ereignisaktion für Zahlungsabbruch (cancel)

### Gefixt

- JS-Fehler - doppelter Button
- sauberes Logging
- Versionsinfo und Kommentar in Amazon Calls

## 1.1.4

### Gefixt

- zweite Ursache für doppelten Button

## 1.1.3

### Hinzugefügt

- Einstellbares Logging

### Gefixt

- Verhalten bei Transaction Timeouts
- Doppelter Button bei neuer Ceres Version

## 1.1.2

### Hinzugefügt

- kompromiertes JS und CSS

### Gefixt

- Ceres Sprachbausteine

## 1.1.1

### Hinzugefügt

- einstellbarer Status bei Autorisierung

### Gefixt

- JS Event Probleme in manchen Templates bei der Auswahl der Versandart
- Fehlermeldung bei Abgelehnten Einzugsversuchen (capture)
- AGB/Datenschutz-Checkbox in Checkout
- Kompatibilität mit neuem Trailing Slash Feature

## 1.1.0

### Hinzugefügt

- Multi Currency Feature

### Gefixt

- E-Mail-Adresse und Telefonnummer im Kundendatensatz
- Checkout auf Artikelseite mit Popup

## 1.0.4

### Gefixt

- Autorisierung in Popup
- JS/CSS nicht mehr auf alkim.de gehostet

## 1.0.3

### Hinzugefügt

- Amazon Pay Button auf Artikelseite (Schnellkauf)
- Bilder und Varianten auf Checkout-Seite

## 1.0.2

### Gefixt

- Kompatibilität Ceres 2.x

## 1.0.1

### Hinzugefügt

- Hausnummer separat speichern

## 1.0.0

### Hinzugefügt

- Login Funktionalität

## 0.1.11

### Gefixt

- mit der Entwicklung von Plenty Schritt halten

## Veröffentlichung 0.1.10