describe('Fluxo de compra corrigido', () => {
  const email = `cliente${Date.now()}@teste.com`;
  const senha = 'senha123';

  before(() => {
    cy.visit('http://localhost:8000/cliente/register');
    cy.get('input[name="name"]').type('Cliente Teste');
    cy.get('input[name="email"]').type(email);
    cy.get('input[name="password"]').type(senha);
    cy.get('input[name="password_confirmation"]').type(senha);
    cy.get('button[type="submit"]').click();
    cy.url().should('not.include', '/register');
  });

  beforeEach(() => {
    // Faz login direto para garantir que a sessão está ativa
    cy.visit('http://localhost:8000/cliente/login');
    cy.get('input[name="email"]').type(email);
    cy.get('input[name="password"]').type(senha);
    cy.get('button[type="submit"]').click();
    cy.url().should('not.include', '/login');
  });

  it('1 - Adiciona produto ao carrinho', () => {
    cy.visit('http://localhost:8000');

    cy.get('form[action="/cart/add"]').first().within(() => {
      cy.get('input[name="quantidade"]').clear().type('1');
      cy.get('button[type="submit"]').click();
    });

    cy.visit('http://localhost:8000/cart');
    cy.contains('Carrinho').should('exist');
  });

  it('2 - Preenche o endereço', () => {
    cy.visit('http://localhost:8000/endereco');

    cy.get('input[name="rua"]').should('be.visible').type('Rua Teste');
    cy.get('input[name="numero"]').type('100');
    cy.get('input[name="bairro"]').type('Centro');
    cy.get('input[name="cidade"]').type('São Paulo');
    cy.get('input[name="estado"]').type('SP');

    cy.get('button[type="submit"]').click();
    cy.url().should('include', '/entrega');
  });

  it('3 - Escolhe retirada e forma de pagamento', () => {
    cy.visit('http://localhost:8000/retirada');

    cy.get('input[name="forma_pagamento"][value="credito"]').should('exist').check({ force: true });
    cy.get('button[type="submit"]').click();

    cy.url().should('include', '/pedidos');
    cy.contains('Pedido').should('exist');
  });
});
