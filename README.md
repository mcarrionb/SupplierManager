# SupplierManager

Aquest projecte és una aplicació Symfony per a la gestió de proveïdors, preparada per funcionar amb Docker i Composer.

En versions futures es preveu:
- Millorar l’experiència d’usuari amb una interfície més moderna i refinada.
- Afegir animacions i transicions suaus per a una navegació més fluida.
- Integració amb API REST per a funcionalitats externes.
- Autenticació i rols d’usuari per gestionar permisos.

## Estructura de Carpetes

- **bin/**: Scripts executables.
- **config/**: Configuració de l'aplicació.
  - **packages/**: Configuració específica de paquets i entorns.
  - **routes/**: Definició de rutes personalitzades.
- **docker/**: Scripts i fitxers auxiliars per a la imatge Docker (aquí hi ha el entrypoint.sh).
- **migrations/**: Fitxers de migració de base de dades generats per Doctrine.
- **public/**: Arrel pública del projecte.
- **src/**: Codi font de l'aplicació.
  - **Command/**: Comandes personalitzades de Symfony per afegir dades a la base de dades.
  - **Controller/**: Controladors que gestionen les rutes i la lògica de negoci.
  - **Entity/**: Entitats de Doctrine.
  - **Enum/**: Enums utilitzats a l'aplicació.
  - **Form/**: formularis.
  - **Repository/**: Repositoris de Doctrine per accedir a les dades.
- **templates/**: Plantilles Twig per a la interfície d'usuari.
- **var/**: Fitxers temporals i de cache.
- **vendor/**: Dependències instal·lades per Composer.

## Dockerfile

El `Dockerfile` defineix la imatge del contenidor per executar l'aplicació Symfony amb Apache i PHP:
- Utilitza una imatge base de PHP 8.2 amb Apache.
- Instal·la extensions necessàries i Composer per gestionar les dependències.
- Copia el codi de l'aplicació al contenidor.
- Configura Apache perquè el directori públic sigui `public/`.
- Executa un script d'entrada per esperar la base de dades, aplicar migracions i arrencar el servidor web.

## compose.yaml

El fitxer `compose.yaml` defineix els serveis Docker necessaris per al desenvolupament:
- **app**: el servei principal de Symfony.
- **db**: la base de dades MySQL, amb variables d'entorn per a la configuració.

## composer.json

El fitxer `composer.json` gestiona les dependències PHP del projecte:
- Llista els paquets de Symfony i altres llibreries necessàries.
- Defineix scripts.
- Permet instal·lar, actualitzar i autocarregar les dependències del projecte.

---

## Posada en marxa ràpida

1. **Clona el repositori**
2. **Executa**: `docker compose up --build`
3. Accedeix a l'aplicació a [http://localhost:8080](http://localhost:8080)

