import home from '../fixtures/home.json'
import selectors from '../fixtures/selectors.json'
import componentPage from '../fixtures/components.json'

describe("Magento Home page.", () => {
    beforeEach(() => {
        cy.visit(home.homeUrl)
    })

    it("Can visit the homepage", () => {
      cy.get(selectors.mainInfo)
        .should('contain.text', home.info);

      cy.get(selectors.mainTitle)
        .should('contain.text', home.title);
    });
    
    it("Can confirm product Qty", () => {
      cy.get(selectors.productCard)
        .should('have.length.gte', 1);
    });

});

describe("Observables component", () => {
  beforeEach(() => {
      cy.visit(componentPage.componentUrl);
  })

  it("Can visit the component page", () => {
  //  Check the title
    cy.get(selectors.selectorComponentTitle)
    .should('contain.text', componentPage.componentTitle);

    // Check the Content
    cy.get(selectors.selectorComponentContent)
    .should('contain.text', componentPage.componentContent);

    cy.get(selectors.selectorComponentInput)
    .type("test1234")
    .should("have.value", "test1234");
    
    // Check the the new value of the Content
    cy.get(selectors.selectorComponentContent)
    .should('contain.text', componentPage.componentNewContent);
    
    cy.get(selectors.selectorCountInteger)
    .should('contain.text', componentPage.componentCountInteger);
  });

});