context('Actions', () => {

    beforeEach(() => {
        cy.writeFile('var/log/behat.log', '')
    })

    it ('User can signUp', () => {
        cy.request({
            method: 'POST',
            url: '/users', // baseUrl is prepended to url
            body: {
                userName: 'JohnDoe',
                email: 'test.email@gmail.com',
                password: ',\u0026+3RjwAu88(tyC\u0027'
            }
        })
            .then((resp) => {
                expect(resp.status).to.eq(200)
                expect(resp.body).to.contains(
                    {
                        userName: "JohnDoe",
                        email: "test.email@gmail.com",
                        password: ",&+3RjwAu88(tyC'",
                    }
                )
            })
    })

    it ('SignUp User but email exists in database', () => {
       cy.request({
           method: 'POST',
           url: '/users',
           failOnStatusCode: false,
           body: {
               userName: 'JohnDoe2',
               email: 'test.email@gmail.com',
               password: ',\u0026+3RjwAu88(tyC\u0027'
           }
       })
           .then((resp) => {
               expect(resp.status).to.eq(400)
               expect(resp.body).eq('User email is in use')
           })

        cy.readFile('var/log/behat.log').should('contain', 'app.ERROR: User email is in use')
    })

    it ('SignUp User but username exists in database', () => {
        cy.request({
            method: 'POST',
            url: '/users',
            failOnStatusCode: false,
            body: {
                userName: 'JohnDoe',
                email: 'test.email2@gmail.com',
                password: ',\u0026+3RjwAu88(tyC\u0027'
            }
        })
            .then((resp) => {
                expect(resp.status).to.eq(400)
                expect(resp.body).eq('Username is in use')
            })

        cy.readFile('var/log/behat.log').should('contain', 'app.ERROR: Username is in use')
    })

    it ('SignUp User with invalid user and return 400 status code', () => {
        cy.request({
            method: 'POST',
            url: '/users',
            failOnStatusCode: false,
            body: {
                userName: '',
                email: 'test.email@gmail.com',
                password: ',\u0026+3RjwAu88(tyC\u0027'
            }
        })
            .then((resp) => {
                expect(resp.status).to.eq(400)
                expect(resp.body).eq('Username invalid by policy rules')
            })

        cy.readFile('var/log/behat.log').should('contain', 'app.ERROR: Username invalid by policy rules')
    })

    it ('SignUp User with invalid email and return 400 status code', () => {
        cy.request({
            method: 'POST',
            url: '/users',
            failOnStatusCode: false,
            body: {
                userName: 'JohnDoe',
                email: 'test.emailgmail.com',
                password: ',\u0026+3RjwAu88(tyC\u0027'
            }
        })
            .then((resp) => {
                expect(resp.status).to.eq(400)
                expect(resp.body).eq('Invalid Email format')
            })

        cy.readFile('var/log/behat.log').should('contain', 'app.ERROR: Invalid Email format')
    })

    it ('SignUp User with invalid password and return 400 status code', () => {
        cy.request({
            method: 'POST',
            url: '/users',
            failOnStatusCode: false,
            body: {
                userName: 'JohnDoe',
                email: 'test.email@gmail.com',
                password: ',&+3Rj'
            }
        })
            .then((resp) => {
                expect(resp.status).to.eq(400)
                expect(resp.body).eq('Password invalid by policy rules')
            })

        cy.readFile('var/log/behat.log').should('contain', 'app.ERROR: Password invalid by policy rules')
    })
})
