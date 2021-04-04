import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';

const Show = ({cliente}) => {

    return (
        <div>
            <table className="table-auto w-full">
                <tbody>
                    <tr>
                        <td className="border px-4 py-2"><strong>Nome</strong></td>
                        <td className="border px-4 py-2">{ cliente.nome }</td>
                    </tr>
                    <tr>
                        <td className="border px-4 py-2"><strong>Email</strong></td>
                        <td className="border px-4 py-2">{ cliente.email }</td>
                    </tr>
                    <tr>
                        <td className="border px-4 py-2"><strong>Tipo</strong></td>
                        <td className="border px-4 py-2">{ cliente.tipo }</td>
                    </tr>
                </tbody>
            </table>

            <div className="max-w-7xl mx-auto mt-8">
                <InertiaLink
                    href={ route('cliente.index') }
                    className="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded">
                    Voltar
                </InertiaLink>
            </div>
        </div>
    );
}

export default Show;