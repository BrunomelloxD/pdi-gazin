# 🧪 Testes Unitários em Laravel com Docker

## 📦 Como subir a aplicação

Execute o comando abaixo para subir a aplicação com Docker:

```bash
docker-compose up --build -d
```

A aplicação ficará disponível no ambiente definido no seu `docker-compose.yml`.

## ✅ Como rodar os testes

Execute o comando abaixo para rodar os testes:

```bash
docker-compose exec app php artisan test
```

---


# 🧪 Importância dos Testes Unitários com e sem Mock

## 📌 Descrição

Este repositório demonstra boas práticas no desenvolvimento de testes unitários utilizando **PHP (Laravel)**, abordando testes tanto **com mock** quanto **sem mock**.

O objetivo é evidenciar como testes bem elaborados são fundamentais para garantir:

- ✅ Qualidade do código
- ✅ Facilidade na manutenção
- ✅ Confiabilidade no desenvolvimento
- ✅ Agilidade na evolução do projeto

---

## 🚀 Por que escrever testes unitários?

Testes unitários são uma prática essencial no desenvolvimento profissional de software. Eles trazem diversos benefícios:

- 🛡️ **Maior qualidade de código:** Problemas são detectados na fase de desenvolvimento.
- 🔄 **Refatoração com segurança:** Mudanças não quebram funcionalidades existentes.
- 🔥 **Feedback rápido:** Saber rapidamente se algo quebrou.
- 📜 **Documentação viva:** Mostra como as unidades do sistema devem se comportar.
- 🤝 **Facilita a colaboração:** Novos devs entendem o sistema mais rapidamente.

---

## 🔍 Diferença entre testes **com Mock** e **sem Mock**

|                         | **Testes com Mock**                              | **Testes sem Mock**                             |
|-------------------------|---------------------------------------------------|-------------------------------------------------|
| **Foco**                | Unidade isolada                                  | Unidade + dependências reais                    |
| **Velocidade**          | Muito rápidos                                    | Mais lentos                                     |
| **Acesso a recursos externos** | Não                                          | Sim (banco, cache, APIs, etc.)                  |
| **Confiabilidade no código isolado** | Alta                                 | Média                                           |
| **Detecta erros de integração** | Não                                         | Sim                                             |
| **Quando usar?**        | Testar comportamentos específicos, falhas, regras| Testar fluxo real, integração entre componentes |

---

## 🎯 Por que usar **Mock**?

- ✅ Permite isolar a classe ou método testado.
- ✅ Remove dependências externas como banco de dados, APIs, filas e cache.
- ✅ Testes são **mais rápidos e determinísticos**.
- ✅ Simula cenários difíceis de reproduzir (como falha de API ou banco).
- ✅ Garante foco no comportamento da **unidade de código**.

---

## 🚫 Quando evitar Mock?

- Quando se deseja testar a integração real entre componentes.
- Quando o teste depende de regras de negócio distribuídas entre múltiplos serviços.
- Em testes de integração e testes end-to-end.

---

## 🏗️ Estrutura dos Testes

Este repositório possui exemplos de testes:

### ✅ Testes Unitários com Mock
- Foca em testar Controllers e Services isoladamente.
- Utiliza **Mockery** para simular comportamentos de dependências.

### 🔗 Testes Sem Mock (Integração leve)
- Utiliza um banco de dados de teste (SQLite in-memory ou banco de teste).
- Verifica se toda a stack (Controller → Service → Repository → Database) funciona como esperado.

---

## 🔧 Exemplos de Código

### ✔️ Teste com Mock (isolado)

```php
$this->userServiceMock
    ->shouldReceive('getUserById')
    ->once()
    ->with(1)
    ->andReturn(['id' => 1, 'name' => 'User 1']);

$response = $this->getJson('/api/v1/user/1');

$response->assertStatus(200);
$response->assertJsonFragment(['name' => 'User 1']);
```

🟢 **Vantagem:** Não acessa banco, rápido e direto.

---

### 🔗 Teste sem Mock (integração real)

```php
public function testFindUserInDatabase()
{
    $user = User::factory()->create();

    $response = $this->getJson('/api/v1/user/' . $user->id);

    $response->assertStatus(200);
    $response->assertJsonFragment(['name' => $user->name]);
}
```

🟢 **Vantagem:** Garante que Controller, Service e Banco estão funcionando juntos.

---

## 🏆 Boas práticas

- 🧠 **Use Mock:** Para testes rápidos, isolando regras de negócio.
- 🔗 **Use sem Mock:** Para testar integrações internas do projeto.
- 🧪 Combine ambos os tipos de testes no seu pipeline de qualidade.

---

## 🛠️ Tecnologias usadas

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/)
- [PHPUnit](https://phpunit.de/)
- [Mockery](https://github.com/mockery/mockery)
