
Do uruchomienia wymagany jest `docker` i `docker-compose`

1. Zbuduj obrazy dockera `docker-compose build`
1. Zainstaluj zależności `docker-compose run --rm php composer install`.
1. Zainicjalizuj bazę danych `docker-compose run --rm php php bin/console doctrine:schema:create`.
1. Zainicjalizuj kolejkę Messengera `docker-compose run --rm php php bin/console messenger:setup-transports`.
1. Uruchom serwis za pomocą `docker-compose up -d`.

Jeśli wszystko poszło dobrze, serwis powinien być dostępny pod adresem 
[https://localhost](https://localhost).

Przykładowe zapytania (jak komunikować się z serwisem) znajdziesz w [requests.http](./requests.http).

Testy uruchamia polecenie `docker-compose run --rm php php bin/phpunit`

Serwis realizuje obsługę katalogu produktów oraz koszyka. Klient serwisu powinien móc:

* dodać produkt do katalogu,
* usunąć produkt z katalogu,
* wyświetlić produkty z katalogu jako stronicowaną listę o co najwyżej 3 produktach na stronie,
* utworzyć koszyk,
* dodać produkt do koszyka, przy czym koszyk może zawierać maksymalnie 3 produkty,
* usunąć produkt z koszyka,
* wyświetlić produkty w koszyku, wraz z ich całkowitą wartością.

Użytkownicy i testerzy serwisu zgłosili następujące problemy i prośby:

* Chcemy móc dodawać do koszyka ten sam produkt kilka razy, o ile nie zostanie przekroczony limit sztuk produktów. Teraz to nie działa.
* Limit koszyka nie zawsze działa. Wprawdzie, gdy dodajemy czwarty produkt do koszyka to dostajemy komunikat `Cart is full.`, ale pomimo tego i tak niektóre koszyki mają po cztery produkty. 
* Najnowsze (ostatnio dodane) produkty powinny być dostępne na początkowych stronach listy produktów. 
* Musimy mieć możliwość edycji produktów. Czasami w nazwach są literówki, innym razem cena jest nieaktualna.
