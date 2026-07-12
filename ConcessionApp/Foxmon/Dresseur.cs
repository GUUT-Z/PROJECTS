using System;
using System.Collections.Generic;
using System.Data;

namespace projetFoxmon
{
    public class Dresseur
    {
        public string Nom { get; set; }
        public int X { get; set; }
        public int Y { get; set; }
        private List<Foxmon> Equipe { get; set; }

        public Dresseur(string nom, int x, int y)
        {

            Nom = nom;
            X = x;
            Y = y;
            Equipe = new List<Foxmon>();

        }

        public void AjouterSiPossible(Foxmon foxmon, int maxEquipe = 6)
        {
            if (Equipe.Count < maxEquipe)
            {
                Equipe.Add(foxmon);
            }
            else
            {
                Console.WriteLine("Votre équipe est déjà complète !");
            }
        }

        public Foxmon? PremierFoxmon()
        {
            if (Equipe.Count > 0)
            {
                return Equipe[0];
            }
            return null;
        }
        public bool Capturer(Foxmon cible)
        {
            int ChanceBase = 20;
            int bonus = (cible.PVM - cible.PV) * 30 / cible.PVM;
            int ChanceTotale = ChanceBase + bonus;

            int tirage = new Random().Next(0, 100);
            if (tirage < ChanceTotale)
            {
                Console.WriteLine($"Félicitations ! Vous avez capturé {cible.Nom} !");
                AjouterSiPossible(cible);
                return true;
            }
            else
            {
                Console.WriteLine($"Oh non ! {cible.Nom} a échappé à la capture !");
                return false;
            }
        }

        public bool Fuir()
        {
            ConsoleKey touche = Console.ReadKey(true).Key;
            if (touche == ConsoleKey.Escape)
            {
                Console.WriteLine("T'as fui le combat.");
                return true;
            }
            return false;
        }

        public Foxmon ProchainFoxmonDisponible()
        {
            foreach (var f in Equipe)
            {
                if (f.PV > 0)
                    return f;
            }
            return Equipe[0];
        }
    }

}