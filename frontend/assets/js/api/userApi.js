const API_BASE = '/api/users';

export async function createUser(data) {
    const response = await fetch(API_BASE, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });

    const result = await response.json();
    if (!response.ok) throw new Error(result.message || 'Erro desconhecido');
    return result;
}
