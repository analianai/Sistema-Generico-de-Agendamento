# Sistema Genérico de Agendamento

Este projeto é um site responsivo Genérico de Agendamento e utiliza como exemplo um salão de Beleza, criado utilizando o framework Bootstrap. O objetivo é fornecer informações claras e acessíveis para clientes, incluindo serviços, mídia, FAQs e contato.

## Tecnologias Utilizadas
- **PHP**: Estrutura do site e backend.
- **CSS3**: Estilização adicional (quando necessário).
- **Bootstrap 5**: Framework utilizado para design responsivo e componentes pré-prontos.
- **JavaScript**: Para interatividade (modais e outros componentes do Bootstrap).

## Páginas

### 1. **Início (index.php)**
- Contém um carrossel responsivo que apresenta o salão e seus destaques.
- Seções principais como Sobre, Serviços, e Contato são resumidas.

### 2. **Sobre (sobre.php)**
- Apresenta a história e os valores do salão (Missão, Visão e Valores).
- Inclui depoimentos de clientes satisfeitos.

### 3. **Mídia (midia.php)**
- Exibe fotos e vídeos organizados em seções separadas.
- Cada item está em um card responsivo, com botão para mais detalhes.

### 4. **Serviços (servicos.php)**
- Lista os serviços oferecidos pelo salão, como corte de cabelo, coloração, manicure, entre outros.
- Cada serviço possui um botão que abre um modal com mais detalhes.

### 5. **FAQ (faq.php)**
- Inclui informações de contato organizadas em colunas responsivas.
- Um Accordion de perguntas frequentes (FAQ) sobre o funcionamento do salão.

## Funcionalidades

- **Navbar Responsiva**: Menu de navegação fixo no topo com colapsível em dispositivos móveis.
- **Carrossel**: Apresenta imagens e mensagens principais.
- **Modais**: Exibe detalhes de serviços ao clicar nos botões "Saiba mais".
- **Accordion**: Para organização de perguntas frequentes.
- **Layout Responsivo**: Design adaptado para diferentes dispositivos.

## Como Utilizar
1. Clone este repositório:
   ```bash
   git clone https://github.com/seu-repositorio/salao-de-beleza.git
   ```
2. Abra os arquivos no navegador ou use um servidor local para visualização.
3. Navegue pelas páginas e explore as funcionalidades.

## Estrutura de Arquivos
```
/
|-- index.php         # Página inicial
|-- sobre.php         # Sobre nós
|-- midia.php         # Página de mídia
|-- servicos.php      # Página de serviços
|-- faq.php           # Contato e duvidas
|-- sing_in.php       # Página de login
|-- sing_in.php       # Página de Cadastro
|-- /assets           # Diretório de midias
|-- ----/css          # Diretório de arquivos CSS (opcional)
|-- ----/img          # Diretório de imagens
|-- ----/JS           # Diretório de FavaScript
|-- /Area Segura      # Diretório dp 
|-- ----admin_dashboard.php
|-- ----admin_relatorio.php
|-- ----admin_servico.php
|-- ----user_dashboard.php
|-- /componentes      # Diretório dos componentes
|-- ----menu.php
|-- ----menuSeguro.php
|-- ----footer.php
|-- /conexao          # Diretório dos Conexão com BD
|-- ----Login.php
|-- ----Logout.php
|-- ----Resister.php
```

## Contribuições
Contribuições são bem-vindas! Por favor, siga os passos abaixo:
1. Fork este repositório.
2. Crie uma branch para sua funcionalidade ou correção: `git checkout -b feature/nova-funcionalidade`.
3. Submeta um pull request.

## Autor
- Desenvolvido por Anália Emília Souza.

## Licença
Este projeto está licenciado sob a [Licença MIT](LICENSE).

