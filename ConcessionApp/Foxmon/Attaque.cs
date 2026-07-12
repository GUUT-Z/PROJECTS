using System;
using System.Collections.Generic;

namespace projetFoxmon
{
    public class Attaque
    {
        public string Nom { get; set; }
        public string Type { get; set; }
        public int Puissance { get; set; }
        public int Precision { get; set; }

        public Attaque(string nom, string type, int puissance, int precision)
        {
            Nom = nom;
            Type = type;
            Puissance = puissance;
            Precision = precision;
        }

        public void Afficher()
        {
            Console.WriteLine($"{Nom} - Type: {Type}, Puissance: {Puissance}, Précision: {Precision}%");
        }

    }


}