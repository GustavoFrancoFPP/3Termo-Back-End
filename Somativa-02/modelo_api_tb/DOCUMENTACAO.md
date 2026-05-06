# DOCUMENTAÇÃO TÉCNICA - POKÉDEX COM CUSTOMIZAÇÃO

**Data**: Maio de 2026  
**Versão**: 1.0

---

## RESUMO EXECUTIVO

Este projeto integra a PokeAPI com um sistema local de Pokémon customizados. O usuário digita um ID ou nome na barra de busca e recebe um resultado. Se o Pokémon estiver armazenado localmente, ele vem de lá. Se não, o sistema busca automaticamente na PokeAPI. Tudo funciona de forma invisível para o usuário.

---

## COMO FUNCIONA

### Para o Usuário

O usuário entra em `http://127.0.0.1:8000/pokedex` e vê uma barra de busca. Digita um ID (tipo 1028) ou um nome (tipo "pikachu"). Clica em buscar. Pronto, a página mostra o Pokémon com todas as informações: imagem, tipo, altura, peso, habilidades e estatísticas.

Se for um Pokémon customizado (criado pela equipe da academia), ele tem um badge azul brilhante escrito "✨ CUSTOMIZADO". Caso contrário, é um Pokémon normal da PokeAPI.

### Nos Bastidores

Quando o usuário faz uma busca, a URL fica assim: `/pokedex?id=1028`

O `PokemonController` recebe essa requisição e:

1. Procura no banco de dados local (tabela `new_mons`) pelo ID 1028
2. Se encontrar → Formata os dados e exibe
3. Se não encontrar → Faz uma requisição para a PokeAPI (`https://pokeapi.co/api/v2/pokemon/1028`)
4. Se a API responder → Formata os dados e exibe
5. Se nem um nem outro tiver → Retorna erro 404

A formatação é importante porque o banco local e a PokeAPI usam estruturas diferentes para os mesmos dados.

---

## ESTRUTURA TÉCNICA

### Banco de Dados - Tabela `new_mons`

```sql
CREATE TABLE new_mons (
  id INT PRIMARY KEY AUTO_INCREMENT,
  pokemon_id INT UNIQUE NOT NULL,          -- ID do Pokémon (1028, 9001, etc)
  name VARCHAR(100) NOT NULL,               -- Nome (Dilodo, Capaculith, etc)
  type VARCHAR(255),                        -- Tipos (Elétrico, Água, etc)
  height DECIMAL(5,2),                      -- Altura em metros
  weight DECIMAL(6,2),                      -- Peso em kg
  image_path VARCHAR(255),                  -- Caminho da imagem salva
  abilities JSON,                           -- Array de habilidades
  stats JSON,                               -- Stats (hp, attack, defense, etc)
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Exemplo de um registro:**

```json
{
  "pokemon_id": 1028,
  "name": "Dilodo",
  "type": "Elétrico",
  "height": 1.30,
  "weight": 60.00,
  "image_path": "pokemons/5pat4hmHnAq1WuKfHOAPf0gzpg00XlvVa6OvoJpA.png",
  "abilities": ["Curto-Circuito", "Estática", "Alma de Sucata"],
  "stats": {
    "hp": 50,
    "attack": 54,
    "defense": 60,
    "special-attack": 70,
    "special-defense": 65,
    "speed": 70
  }
}
```

### O Problema da Formatação

A PokeAPI retorna as estatísticas assim:

```json
[
  {"stat": {"name": "hp"}, "base_stat": 50},
  {"stat": {"name": "attack"}, "base_stat": 54},
  {"stat": {"name": "defense"}, "base_stat": 60}
]
```

Mas nosso banco armazena assim:

```json
{
  "hp": 50,
  "attack": 54,
  "defense": 60
}
```

**Solução:** O controller detecta qual é qual e transforma tudo para o padrão da PokeAPI antes de enviar para a view. Assim, a view nunca precisa se preocupar com essas diferenças.

---

## AS ROTAS

| Rota | O que faz |
|------|-----------|
| `GET /pokedex` | Página principal de busca (exibe Pokémon aleatório se sem parâmetros) |
| `GET /pokedex?id=1028` | Busca específica por ID |
| `GET /pokedex?name=pikachu` | Busca por nome |
| `GET /pokemons` | Lista todos os Pokémon customizados |
| `GET /pokemons-all` | Lista customizados + link para PokeAPI |
| `GET /pokemon/criar` | Formulário para criar novo customizado |
| `POST /pokemon/salvar` | Salva o novo Pokémon no banco |

---

## OS ARQUIVOS PRINCIPAIS

### `PokemonController.php`
Orquestra toda a lógica de busca. Recebe o ID ou nome, procura no banco, busca na API se necessário, transforma os dados e escolhe qual view renderizar.

### `NewMon.php` (Model)
Define como um Pokémon customizado é representado no código. Mapeia a tabela `new_mons` e diz ao Laravel que os campos `abilities` e `stats` são JSON.

### `pokemon.blade.php` (View)
Exibe o Pokémon. Recebe um array já pronto e renderiza em HTML. Verifica se é customizado e exibe o badge se for.

---

## SEGURANÇA

- **SQL Injection**: Usamos Eloquent ORM que automaticamente usa prepared statements
- **Validação de Entrada**: IDs são convertidos para inteiro antes de usar
- **Tratamento de Erros**: Requisições à API estão em try-catch, nunca expõe erros ao usuário
- **Validação de Imagens**: Só aceita JPEG, PNG, GIF com máximo 2MB

---

## O QUE DIFERENCIA ESTE PROJETO

Muitos sistemas só consultam a PokeAPI. Este projeto vai além:

✅ **Cria e armazena** Pokémon customizados  
✅ **Unifica a exibição** - não há diferença visual entre customizado e oficial  
✅ **Prioriza dados locais** - mais rápido para dados que já temos  
✅ **Fallback automático** - busca na PokeAPI se precisar  
✅ **Upload de imagens** - cada customizado pode ter sua própria imagem  

---

## COMO EXPANDIR NO FUTURO

Se você quiser adicionar coisas novas:

- **Cache de requisições PokeAPI**: Para não fazer a mesma requisição duas vezes
- **Dashboard administrativo**: Para gerenciar todos os customizados
- **Histórico de buscas**: Ver quais Pokémon os usuários mais procuram
- **Favoritos**: Usuários salvarem seus Pokémon favoritos
- **Comparador**: Colocar dois Pokémon lado a lado

A arquitetura MVC permite tudo isso sem quebrar o código existente.

---

## CONCLUSÃO

Este é um projeto simples na aparência, mas bem pensado por trás. Integra dados de fora (PokeAPI) com dados internos (customizados) de forma transparente. O código é organizado, fácil de entender e pronto para crescer.

**Status**: ✅ Funcionando  
**Versão**: 1.0  
**Data**: Maio de 2026
