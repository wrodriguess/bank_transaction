# MENTORIA NERIS - 06/09/2024

MOCAR AS SEGUINTES ROTAS:
- Usuarios (User)

Estudar o mocun
https://mockoon.com/

Como instalar mockoon utilizando uma imagem docker?
https://mockoon.com/cli/
https://mockoon.com/docs/latest/about/
https://mockoon.com/tutorials/
https://mockoon.com/training/

--- 

Comando para rodar mockoon cli:
docker run --rm -v "$(pwd)/mockoon/mocks.json:/data/mocks.json" -p 3030:3030 mockoon/cli:latest -d /data/mocks.json --port 3030 --repair

---

