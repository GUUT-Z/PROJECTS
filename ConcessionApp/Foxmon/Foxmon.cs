using System;
using System.Collections.Generic;

namespace projetFoxmon
{
	public class Foxmon
	{
		public string Nom { get; set; }
		public int PV { get; set; }
		public int PVM { get; set; }
		public int LVL { get; set; }
		public int Speed { get; set; }
		public int Degats { get; set; }
		public string TypeElementaire { get; set; }
		public List<Attaque> AttaquesConnues { get; set; }

		// ✔ FIX IMPORTANT
		private static Random rand = new Random();

		private static string[] types = { "Feu", "Eau", "Plante", "Glace", "Métal", "Sol", "Électrique", "Roche" };

		private static double[,] multiplicateurs =
		{
			{1,0.5,2,1,0.5,1,1,0.5},
			{2,0.5,0.5,1,1,2,0.5,2},
			{0.5,2,0.5,1,1,2,1,1},
			{0.5,0.5,2,0.5,1,1,1,1},
			{0.5,0.5,1,2,0.5,2,0.5,2},
			{1,1,0.5,1,2,1,2,2},
			{1,2,1,1,1,0,0.5,1},
			{2,1,1,2,0.5,0.5,1,0.5}
		};

		public Foxmon(string nom, int pv, int pvm, int lvl, int speed, int degats, string typeElementaire)
		{
			Nom = nom;
			PV = pv;
			PVM = pvm;
			LVL = lvl;
			Speed = speed;
			Degats = degats;
			TypeElementaire = typeElementaire;
			AttaquesConnues = new List<Attaque>();
		}

		private int Index(string type)
		{
			for (int i = 0; i < types.Length; i++)
				if (types[i] == type) return i;

			return -1;
		}

		private double Multiplicateur(string attaqueType, string cibleType)
		{
			int i = Index(attaqueType);
			int j = Index(cibleType);

			if (i == -1 || j == -1)
				return 1;

			return multiplicateurs[i, j];
		}

		public void Attaquer(Foxmon cible, Attaque attaque)
		{
			int tirage = rand.Next(0, 100);

			if (tirage < attaque.Precision)
			{
				double multiplicateur = Multiplicateur(attaque.Type, cible.TypeElementaire);
				int degatsInfliges = (int)(attaque.Puissance * multiplicateur);

				cible.PV -= degatsInfliges;
				if (cible.PV < 0) cible.PV = 0;

				Console.WriteLine($"{Nom} utilise {attaque.Nom} !");
				Console.WriteLine($"C'est {(multiplicateur > 1 ? "super efficace" : multiplicateur < 1 ? "pas très efficace" : "efficace")} !");
				Console.WriteLine($"{cible.Nom} perd {degatsInfliges} PV (reste {cible.PV}).");
			}
			else
			{
				Console.WriteLine($"{Nom} rate son attaque !");
			}
		}

		public void Attaques(PanelAttaques panel)
		{
			Random rnd = new Random();

			//filtrer les attaques 
			List<Attaque> possibles = new List<Attaque>();
			foreach (var a in panel.ListeAttaques)
			{
				if (a.Type == TypeElementaire || a.Type == "Normal")
				{
					possibles.Add(a);
				}
			}

			//nombre d'attaques
			int nb = rnd.Next(2, 4);
			for (int i = 0; i < nb && possibles.Count > 0; i++)
			{
				int index = rnd.Next(possibles.Count);
				AttaquesConnues.Add(possibles[index]);
				possibles.RemoveAt(index);//évite les doublons
			}
		}
	}
}