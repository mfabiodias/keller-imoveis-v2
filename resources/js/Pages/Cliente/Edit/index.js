import React, { useState } from 'react';
import { usePage } from '@inertiajs/inertia-react';
import { Inertia } from '@inertiajs/inertia';

const Edit = ({cliente}) => {
    const { errors } = usePage().props;

    const [data, setData] = useState({
        nome: cliente.nome,
        email: cliente.email,
        tipo: cliente.tipo
    });

    function handleSubmit(event) {
        console.log(data, cliente.id)
        event.preventDefault();
        Inertia.put(route('cliente.update', { cliente : cliente.id }), data);
    }

    function handleInputChange(event) {
        const { name, value } = event.target;
        setData({...data, [name]: value});
    }

    return (
        <div>
            <form onSubmit={handleSubmit} className="w-full">
                <div className="w-full px-3 mb-6 md:mb-0">
                    <label className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Nome
                    </label>
                    <input
                        className="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="text"
                        name="nome"
                        value={data.nome ?? ''}
                        onChange={handleInputChange}
                    />
                    { errors.nome && <p className="text-red-500 text-xs italic mb-4">{errors.nome}</p> }
                </div>
                <div className="w-full px-3 mb-6 md:mb-0">
                    <label className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Email
                    </label>
                    <input
                        className="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="email"
                        name="email"
                        value={data.email ?? ''}
                        onChange={handleInputChange}
                    />
                    { errors.email && <p className="text-red-500 text-xs italic mb-4">{errors.email}</p> }
                </div>
                <div className="w-full px-3 mb-6 md:mb-0">
                    <label className="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">
                        Tipo
                    </label>
                    <input
                        className="appearance-none block w-full bg-gray-100 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        type="text"
                        name="tipo"
                        value={data.tipo ?? ''}
                        onChange={handleInputChange}
                    />
                    { errors.tipo && <p className="text-red-500 text-xs italic mb-4">{errors.tipo}</p> }
                </div>
                <button
                    className="px-3 ml-3 py-2 bg-green-400" type="submit">
                    Atualizar
                </button>
            </form>
        </div>
    );
}

export default Edit;