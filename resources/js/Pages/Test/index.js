import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

const Test = ({name}) => {
    return (
        <div>
            <h1>Hello from component INIT!!</h1>
            <p>Meu parametro é {name}</p>
        </div>
    );
}

export default Test;