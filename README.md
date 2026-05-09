# Acceso Norte

Sitio periodístico bajo el dominio **accesonorte.ar**.

Stack: **WordPress** (PHP 8.2 + MariaDB/MySQL). Hosting en SiteGround GoGeek. Theme custom: `wp-content/themes/acceso-norte/`.

## Estructura del repositorio

```
acceso-norte-web/
├── wp-content/
│   └── themes/
│       └── acceso-norte/        ← TODO el código nuestro vive acá
│           ├── style.css        (header WP + nada más)
│           ├── functions.php    (bootstrap del theme)
│           ├── header.php / footer.php
│           ├── home.php         (frente del diario)
│           ├── single.php       (detalle de nota)
│           ├── archive.php      (categorías, tags, autor)
│           ├── search.php
│           ├── 404.php
│           ├── inc/             (PHP particionado: helpers, hooks, etc.)
│           ├── template-parts/  (partials reutilizables)
│           └── assets/          (CSS y JS del front)
├── docker-compose.yml           (WP + MariaDB local)
├── scripts/deploy.sh            (rsync del theme a SiteGround)
├── .github/workflows/deploy.yml (auto-deploy en push a main)
├── .env.example
└── README.md
```

**Lo que NO se versiona**: WordPress core (`wp-admin/`, `wp-includes/`), plugins de terceros, uploads. Todo eso vive en SiteGround y se gestiona desde el admin de WP.

## Setup local

Requisitos: Docker, Docker Compose.

```bash
docker compose up -d
```

Eso levanta:
- **MariaDB** en `localhost:3306` (DB `accesonorte`, user/pass `accesonorte`/`accesonorte`).
- **WordPress** en http://localhost:8080.

La primera vez vas a entrar al wizard de instalación de WP:
1. Idioma → Español (Argentina) o el que prefieras.
2. Title del sitio: `Acceso Norte`.
3. Crear usuario admin.

Después, en el admin (`/wp-admin`):
1. **Apariencia → Temas** → activar **Acceso Norte**.
2. **Ajustes → Lectura** → "La página de inicio muestra: Tus últimas entradas" (default OK; nuestro `home.php` se va a usar).
3. **Ajustes → Enlaces permanentes** → "Nombre de la entrada" (URLs limpias).
4. Crear **Categorías** (Política, Sociedad, Deportes, Cultura, Locales) en **Entradas → Categorías**.
5. Cargar la primera nota en **Entradas → Añadir nueva** y publicar.
6. Recargar http://localhost:8080/ → tu nota debe aparecer en "Últimas".

### Iterar el theme

Editás cualquier archivo en `wp-content/themes/acceso-norte/`. El cambio se ve en vivo (el directorio está montado como volume). Recargá el browser.

### WP-CLI dentro de docker

Para correr comandos `wp ...`:

```bash
docker compose --profile cli run --rm wpcli wp <comando>
# ej:
docker compose --profile cli run --rm wpcli wp post list
docker compose --profile cli run --rm wpcli wp cache flush
```

## Deploy a SiteGround

WordPress está instalado en SiteGround vía 1-click installer (Site Tools → Devs → Instalador de aplicaciones → WordPress). El theme custom se sube por SSH.

### Manual desde local

```bash
export SG_HOST=gtxm1167.siteground.biz
export SG_USER=u2687-...
export SG_WP_PATH=/home/customer/www/accesonorte.ar/public_html
./scripts/deploy.sh
```

### Auto-deploy desde GitHub

Push a `main` con cambios en `wp-content/themes/acceso-norte/**` dispara el workflow [.github/workflows/deploy.yml](.github/workflows/deploy.yml).

Secrets necesarios en el repo (Settings → Secrets and variables → Actions):

| Secret | Valor |
|---|---|
| `SG_HOST` | host SSH (ej. `gtxm1167.siteground.biz`) |
| `SG_USER` | user SSH (ej. `u2687-...`) |
| `SG_WP_PATH` | `/home/customer/www/accesonorte.ar/public_html` |
| `SG_SSH_KEY` | private key (contenido completo, sin passphrase) |
| `SG_PORT` | opcional, default `18765` |

## Plugins recomendados

Instalalos desde el admin de WP en producción (Plugins → Añadir nuevo). En local, instalación equivalente — los volumes los persisten entre `docker compose down`.

| Plugin | Para qué |
|---|---|
| **Yoast SEO** o **Rank Math** | meta tags, sitemap, JSON-LD, Open Graph |
| **Akismet** | anti-spam de comentarios (gratis con cuenta WP.com) |
| **WP-Optimize** o **W3 Total Cache** | cache (si no usás el de SG) |
| **MailPoet** | newsletter |
| **Wordfence** | seguridad básica |
| **Classic Editor** (opcional) | si no querés Gutenberg |

## Modelo conceptual

| Diario | WordPress nativo |
|---|---|
| Sección (Política, etc.) | **Categoría** (taxonomy `category`) |
| Nota / artículo | **Entrada** (post type `post`) |
| Autor | **Usuario** WP (con perfil + avatar Gravatar) |
| Tag | **Etiqueta** (taxonomy `post_tag`) |
| Imagen principal | **Imagen destacada** (featured image) |
| Bajada | **Extracto** (excerpt) |
| Destacada en home | **Sticky post** (Editar → "Fijar al frente") |

Si en algún momento necesitamos campos extra (subtítulo separado, créditos foto, etc.), agregamos **ACF** (Advanced Custom Fields, plugin) y lo declaramos en `inc/acf.php`.
