import React, {Component} from 'react';
import axios from 'axios';

class Customers extends Component {
    constructor() {
        super();
        this.state = { customers: [], loading: true};
    }

    componentDidMount() {
        this.getCustomers();
    }

    getCustomers() {
        axios.get(`http://2d4ac2b67b11.ngrok.io/api/public/customers`).then(response => {
            this.setState({ customers: response.data, loading: false})
        })
    }

    render() {
        const loading = this.state.loading;
        return(
            <div>
                <section className="row-section">
                    <div className="container">
                        <div className="row">
                            <h2 className="text-center">List of customers</h2>
                        </div>
                        {loading || (this.state.customers.length !== 0)? (
                            <div className={'row text-center'}>
                                <span className="fa fa-spin fa-spinner fa-4x"></span>
                            </div>
                        ) : (
                            <div className={'row'}>
                                { this.state.customers.map(customer =>
                                    <div className="col-md-10 offset-md-1 row-block" key={customer.id}>
                                        <ul id="sortable">
                                            <li>
                                                <div className="media">
                                                    <div className="media-left align-self-center">
                                                        <img className="rounded-circle"
                                                             src={customer.logo}/>
                                                    </div>
                                                    <div className="media-body">
                                                        <h4>{customer.name}</h4>
                                                        <p>{customer.description}</p>
                                                    </div>
                                                    <div className="media-right align-self-center">
                                                        <a href={"http://2d4ac2b67b11.ngrok.io/domains/" + customer.subdomain} className="btn btn-default">View portal</a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                )}
                            </div>
                        )}
                    </div>
                </section>
            </div>
        )
    }
}
export default Customers;