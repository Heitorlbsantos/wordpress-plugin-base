# 🧱 Guia de Boas Práticas – Plugin Base WordPress

Este projeto serve como base para o desenvolvimento de plugins WordPress organizados, reutilizáveis e com uma estrutura limpa e padronizada. Siga as convenções abaixo para garantir consistência, segurança e manutenibilidade no código.

---

## 📁 Estrutura de Diretórios

```bash
plugin-nome/
├── plugin-nome.php         # Arquivo principal do plugin (nome igual ao diretório)
├── includes/               # Lógica PHP principal: hooks, classes, funções
├── assets/                 # Arquivos públicos: JS, CSS, imagens
│   ├── css/
│   ├── js/
│   └── images/
├── views/                  # Templates utilizados no admin ou front-end
├── languages/              # Arquivos de tradução (.mo, .po)
├── index.php               # Arquivo de segurança para evitar acesso direto
```

> 🧠 Use **kebab-case** (letras minúsculas e hífens) para nomes de diretórios e arquivos.

---

## 🧑‍💻 Convenções de Código

### 🔤 Nomes de Arquivos

- Sempre em **kebab-case**: `custom-post-type.php`, `admin-menu.php`
- Prefixe os arquivos com o identificador do plugin, se necessário: `plugin-nome-functions.php`

---

### 🧩 Funções

- Use **snake_case** e prefixo único para evitar conflitos:

```php
function meu_plugin_registrar_post_type() {}
```

> Exemplo de bom prefixo: `meu_plugin_`, `slider_base_`, `cta_plugin_`

---

### 🧱 Classes

- Use **PascalCase** (UpperCamelCase).
- Prefixe com namespace do plugin:

```php
class MeuPlugin_SliderManager {}
```

---

### 💬 Comentários de Métodos

Use PHPDoc para descrever argumentos e retornos das funções e métodos:

```php
/**
 * Salva as configurações do plugin.
 *
 * @param array $dados Dados enviados do formulário.
 * @return bool Verdadeiro se salvo com sucesso.
 */
public function salvar_configuracoes(array $dados): bool {
    // lógica
}
```

---

### 🏷️ Constantes

- Use **letras maiúsculas com underline** e prefixo único:

```php
define('MEU_PLUGIN_VERSION', '1.0.0');
define('MEU_PLUGIN_PATH', plugin_dir_path(__FILE__));
```

---

## 🔐 Boas Práticas de Segurança

### 🔒 index.php nas pastas

Adicione um arquivo `index.php` vazio em todas as pastas (`includes`, `assets`, `views`, etc) para evitar listagem de diretório:

```php
<?php
// Silence is golden.
```

---

### 🛡️ Bloquear acesso direto aos arquivos PHP

Adicione no início de **todos os arquivos PHP** do plugin:

```php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
```

---

### 👤 Verificação de Permissões

Antes de executar ações administrativas, verifique se o usuário tem permissão adequada:

```php
if (!current_user_can('manage_options')) {
    wp_die(__('Você não tem permissão para acessar esta página.', 'meu-plugin'));
}
```

---

### 🧼 Sanitização de Dados

Sempre sanitize entradas do usuário antes de salvar:

```php
$nome = sanitize_text_field($_POST['nome']);
$email = sanitize_email($_POST['email']);
$url = esc_url_raw($_POST['site_url']);
```

---

### ✨ Escapamento de Dados

Escape toda saída que for renderizada no HTML:

```php
echo esc_html($titulo);
echo esc_attr($valor);
echo esc_url($link);
```

---

### 🧷 Uso de Nonces

Para formulários e ações seguras no painel admin:

**1. Gerar nonce:**

```php
wp_nonce_field('meu_plugin_salvar_config', 'meu_plugin_nonce');
```

**2. Verificar nonce:**

```php
if (!isset($_POST['meu_plugin_nonce']) || !wp_verify_nonce($_POST['meu_plugin_nonce'], 'meu_plugin_salvar_config')) {
    wp_die('Ação não autorizada.');
}
```

---

## 📚 Organização de Código

- Centralize **hooks e ações** dentro da pasta `includes/`.
- Separe responsabilidades:
  - `admin-menu.php` → menus do painel
  - `post-types.php` → tipos de post customizados
  - `enqueue.php` → scripts e estilos
- Evite funções globais soltas; use **classes ou agrupamentos** lógicos.

---

## 🌍 Tradução

- Carregue arquivos de tradução da pasta `languages/`:

```php
load_plugin_textdomain('meu-plugin', false, dirname(plugin_basename(__FILE__)) . '/languages');
```

---

## ✅ Checklist ao Criar Novo Plugin

- [ ] Nome da pasta e do arquivo principal seguem o padrão `plugin-nome`.
- [ ] Estrutura de diretórios respeitada.
- [ ] Prefixos aplicados em todas as funções, classes e constantes.
- [ ] Comentários documentando os métodos com `@param` e `@return`.
- [ ] Verificação de `ABSPATH` em todos os arquivos PHP.
- [ ] Arquivo `index.php` presente em cada diretório.
- [ ] Uso de `current_user_can()` onde necessário.
- [ ] Dados sanitizados antes de salvar.
- [ ] Dados escapados antes de exibir.
- [ ] Uso de `nonce` em formulários e ações sensíveis.
- [ ] Arquivos de tradução prontos (se aplicável).

---

**Mantenha consistência. Código limpo, seguro e previsível é mais fácil de evoluir.
Lembre-se: Quem é fiel no pouco também é no muito.**
