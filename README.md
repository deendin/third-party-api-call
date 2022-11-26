# The 'Third Party API Request' Challenge with PHP
## Solution notes
This solution sends a network request to a third party API : [Reqres.In] https://reqres.in/api. It fetches a single user record and it also fetches all user lists. There is a spec folder in this solution which holds the unit tests that test against the endpoints and some few status codes.

### How has this been done?
In order to effectively communicate with a third party API, the following are what has been taken care of:

- This implementation starts with creating some tests against what doesn't exist such as the single user listing endpoint and all users endpoint.
- This implementation also takes care of the user records with pagination to some extent.
- This implementation uses a `App\Transformers\UserTransformer` to transform and expose the data returned from the api to the client.
- In the `UserTransformer`, there is an Objectify trait added which helps in converting an input to an object which is then useful for generating the link in the pagination for the single users list. (Not 100% done though).

### Ambiguities
N/A.

### Tooling
- [Reqres] for the third party API calls.
- [Kahlan] [Kahlan-library] for the test suite.

## Getting started

Before setting up this repository, the following are the dependencies that needs to be available on your machine:

- Composer
- PHP (I have PHP 8.1.11 installed)

## Setup & Instruction

1. Clone the repository: `git clone https://github.com/deendin/third-party-api-call.git`
2. Assuming that the Dependencies listed above are satisfied, you can ```cd``` into the directory called ```third-party-api-call```
3. When inside this repository directory, run ```composer install``` to install the project dependencies.
4. To test, make sure you are still in this repository directory and in your terminal, to run the test suite run ```vendor/bin/kahlan``.

## The task / Specifications
Create a Composer package that provides a service for retrieving users via a remote API (integrate with the https://reqres.in/ dummy API for the purposes of this test). The service should support: 

1. A method to retrieve a single user by ID 
2. A method to retrieve a paginated list of users 
3. The service should convert the returned data to a simple, JSON serializable user model for consumption by the user of the package.


## Next Steps / What I could have done better if I had more time:
1. Complete the pagination such that when the generated link is clicked, it returns the appropriate response for the api and the next set of data.
2. As described in the specification, it is ideal to have in mind that third party API's are not 100% dependable. One of the ways this can be solved is to either have an Exception base class that will be called when the API returns any exception between `500` status code and above, when this happens, I would handle this by persisting the api request to a database with it's status which could be called failed and then the `retry_count` to hold number of times this api has been retried. Another possible solution to handle instable API could be due to rate limiting. To handle this, if I had more time, I would have persisted all my request to a database and then make sure all requests goes through a `Queue`. This way, when the rate limit is reached, I will be able to keep track of API's that are waiting to be sent and no API request will be left without been sent to the third-party library. The very last alternative I am thinking of is to simply handle the rate-limiting within the code level by having an helper that checks if the rate limit is for example between 20 request in a minute, so, for every request that's been sent, I can have a counter that will be incremented after an API is sent, and then a reducer that will keep track of the remaining minute (in seconds), if the number of request sent is now above 20 in a single minute, the request can be stored in a database and then be retriggered in the next minute.
2. Add Github Action for PHP-CS-Fixer that will be triggered before commit or push. This will act like a pre-commit
3. Possibly enforce Husky to automatically test and lint code before commit or push. This will be useful because explicitly running the test command won't be needed anymore.
4. Add docker to dockerize the system. This will allow setting up the project to be seamless irrespective of the machine or system that it needs to be run on.