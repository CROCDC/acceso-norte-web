#!/usr/bin/env bash
# Deploy del theme custom a SiteGround vía SSH.
#
# Solo sincronizamos `wp-content/themes/acceso-norte/`. WordPress core,
# plugins y uploads viven en SiteGround y se manejan desde el admin de WP.
#
# Uso (desde local):
#   ./scripts/deploy.sh
#
# Variables requeridas (en entorno o ~/.ssh/config):
#   SG_HOST     — host SSH de SiteGround (ej. gtxm1167.siteground.biz)
#   SG_USER     — user SSH (ej. u2687-...)
#   SG_WP_PATH  — path absoluto al WP install en SG
#                 (típicamente /home/customer/www/<dominio>/public_html)
#   SG_PORT     — opcional; default puerto SSH del plan (18765 en GoGeek)
set -euo pipefail

: "${SG_HOST:?SG_HOST no seteado}"
: "${SG_USER:?SG_USER no seteado}"
: "${SG_WP_PATH:?SG_WP_PATH no seteado}"

ssh_port_flag=""
if [[ -n "${SG_PORT:-}" ]]; then
  ssh_port_flag="-p ${SG_PORT}"
fi

theme_local="wp-content/themes/acceso-norte/"
theme_remote="${SG_WP_PATH}/wp-content/themes/acceso-norte/"

echo "→ Sincronizando theme a ${SG_USER}@${SG_HOST}:${theme_remote}"
rsync -avz --delete \
  -e "ssh ${ssh_port_flag}" \
  --exclude 'node_modules' \
  --exclude '.DS_Store' \
  --exclude 'assets/dist' \
  "$theme_local" "${SG_USER}@${SG_HOST}:${theme_remote}"

echo "✓ Deploy completo"
