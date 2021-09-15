function getCurp() {
    return document.getElementById("curp").value

}

function validarCurp(curp) {
    const regexCurp = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/
    return regexCurp.test(curp)
}

function comprobarEdad(curp) {
    const anio = curp.substring(4, 6);
    const mes = curp.substring(6, 8);
    const dia = curp.substring(8, 10);
    return new Date((new Date() - (new Date(parseInt(anio), parseInt(mes) - 1, parseInt(dia))))).getFullYear() - 1970;
}

function getEmail() {
    return document.getElementById("email").value
}
