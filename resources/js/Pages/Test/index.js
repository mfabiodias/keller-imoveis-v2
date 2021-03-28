import React from 'react';
import { Button } from 'reactstrap';

const Test = ({name}) => {
    return (
        <div>
            <h1>Hello from component INIT!!</h1>
            <p>Meu parametro é {name}</p>
            <Button color="danger">Danger!</Button>
        </div>
    );
}

export default Test;