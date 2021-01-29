import React from 'react';
import './ErrorNotification.scss';

class ErrorNotification extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            code: 500,
            message: 'Something went wrong, please try again.'
        }
    }

    render() {
        return (
            <article className="error-notification-style">
                <p>{this.state.code} - {this.state.message}</p>   
            </article>
        );
    }
}

export default ErrorNotification;