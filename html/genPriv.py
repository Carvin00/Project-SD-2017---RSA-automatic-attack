import pyasn1.codec.der.encoder
import pyasn1.type.univ
import base64
import sys 


# print "<<I valori di p, q ed e vanno inseriti in formato decimale>>"
p = int(sys.argv[1])
q = int(sys.argv[2])
e = int(sys.argv[3])
output_file = "privata.pem"

# Algoritmo di Euclide Esteso, versione ricorsiva
# def egcd(a, b):
#     if a == 0:
#         return (b, 0, 1)
#     else:
#         g, y, x = egcd(b % a, a)
#         return (g, x - (b // a) * y, y)


# Algoritmo di Euclide Esteso, versione iterativa
def egcd(a, b):
        x,y, u,v = 0,1, 1,0
        while a != 0:
            q, r = b//a, b%a
            m, n = x-u*q, y-v*q
            b,a, x,y, u,v = a,r, u,v, m,n
        gcd = b
        return gcd, x, y

# Calcolo dell'inversa moltiplicativa
def modinv(a, m):
     gcd, x, y = egcd(a, m)
     if gcd != 1:
         return None  # l'inversa moltiplicativa non esiste
     else:
         return x % m
 
# Struttura di una chiave privata RSA in formato PEM
def pempriv(n, e, d, p, q, dP, dQ, qInv):
     template = '-----BEGIN RSA PRIVATE KEY-----\n{}-----END RSA PRIVATE KEY-----\n'
     seq = pyasn1.type.univ.Sequence()
     for x in [0, n, e, d, p, q, dP, dQ, qInv]:
         seq.setComponentByPosition(len(seq), pyasn1.type.univ.Integer(x))
     der = pyasn1.codec.der.encoder.encode(seq)
     return template.format(base64.encodestring(der).decode('ascii'))

#Controllo che p sia maggiore di q 
if p < q: 
	a = p
	p = q
	q = a

# Calcolo dei campi di una chiave privata RSA in formato PEM
n = p * q
phi = (p -1)*(q-1)
d = modinv(e,phi)
dp = modinv(e,(p-1))
dq = modinv(e,(q-1))
qi = modinv(q,p)

# Creazione e salvataggio di una chiave privata RSA in formato PEM 
key = pempriv(n,e,d,p,q,dp,dq,qi)  
f = open(output_file,"w")
f.write(key)
f.close()

